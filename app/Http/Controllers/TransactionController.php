<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Property;
use App\Models\Transaction;
use App\Models\Installment;
use App\Services\InstallmentService;
use Illuminate\Support\Facades\Auth;
use Midtrans\Config;
use Midtrans\Snap;
use Barryvdh\DomPDF\Facade\Pdf;

class TransactionController extends Controller
{
    public function __construct()
    {
        Config::$serverKey = config('services.midtrans.server_key');
        Config::$isProduction = config('services.midtrans.is_production');
        Config::$isSanitized = config('services.midtrans.is_sanitized');
        Config::$is3ds = config('services.midtrans.is_3ds');
    }

    public function checkout(Request $request, $id)
    {
        $request->validate([
            'method' => 'sometimes|in:booking,dp,cash',
            'installment' => 'sometimes|in:none,monthly,quarterly,semi_annually',
        ]);

        $property = \App\Models\Property::findOrFail($id);

        if ($property->status === 'sold') {
            return redirect()->back()->with('error', 'Unit ini sudah terjual dan tidak dapat dipesan');
        }

        $price_base = $property->price > 0 ? $property->price : config('payment.default_price');

        $method = $request->get('method', 'booking');
        $installmentPlan = $request->get('installment', 'none');

        if ($method === 'booking') {
            $price_raw = config('payment.booking_fee');
            $ipl_base = $price_raw;
        } elseif ($method === 'dp') {
            $price_raw = $price_base * config('payment.dp_rate');
            $ipl_base = $price_base;
        } else {
            $price_raw = $price_base;
            $ipl_base = $price_base;
        }

        $ipl = $property->ipl_cost > 0 ? $property->ipl_cost : ($ipl_base * config('payment.ipl_rate'));
        $tax = $property->tax_cost > 0 ? $property->tax_cost : ($ipl_base * config('payment.tax_rate'));

        $grossAmountOriginal = $price_raw + $ipl + $tax;

        $installmentData = null;
        $installmentTotal = $grossAmountOriginal;
        $serviceFee = 0;
        $installmentCount = 1;
        $installmentPeriodMonths = 1;

        if ($installmentPlan !== 'none' && in_array($method, ['booking', 'dp'])) {
            $installmentData = InstallmentService::calculate($grossAmountOriginal, $installmentPlan);
            $installmentTotal = $installmentData['total_with_fee'];
            $serviceFee = $installmentData['service_fee'];
            $installmentCount = $installmentData['installment_count'];
            $installmentPeriodMonths = $installmentData['installment_period_months'];
        }

        $grossAmount = $installmentTotal;

        $property->price_raw = $price_raw;
        $property->ipl = $ipl;
        $property->tax = $tax;

        $project = [
            'id'        => $property->id,
            'name'      => $property->name,
            'price_raw' => $price_raw,
            'ipl'       => $ipl,
            'tax'       => $tax,
        ];

        $total_booking = $grossAmountOriginal;
        $installmentOptions = InstallmentService::plans();

        try {
            $transaction = \App\Models\Transaction::create([
                'user_id'                  => auth()->id(),
                'property_id'              => $id,
                'transaction_code'         => 'TR-WH-' . time(),
                'property_price'           => $price_base,
                'tax_amount'               => $tax,
                'gross_amount'             => $grossAmountOriginal,
                'total_payable'            => $grossAmountOriginal,
                'amount_paid'              => 0,
                'admin_fee'                => 0,
                'payment_status'           => 'pending',
                'payment_type'             => $method,
                'installment_plan'         => $installmentPlan,
                'installment_period_months' => $installmentPeriodMonths,
                'installment_count'        => $installmentCount,
                'service_fee'              => $serviceFee,
                'installment_total'        => $installmentTotal,
                'paid_installments'        => 0,
            ]);

            if ($installmentPlan !== 'none' && $installmentCount > 1) {
                $dueDates = InstallmentService::getDueDates($installmentPlan, $installmentCount);
                foreach ($dueDates as $i => $dueDate) {
                    Installment::create([
                        'transaction_id'     => $transaction->id,
                        'installment_number' => $i + 1,
                        'amount'             => $installmentData['per_installment'] ?? $installmentTotal,
                        'paid_amount'        => 0,
                        'due_date'           => $dueDate,
                        'payment_status'     => 'pending',
                    ]);
                }
            }

            $payAmount = $installmentCount > 1 ? ($installmentData['per_installment'] ?? $installmentTotal) : $installmentTotal;

            $params = [
                'transaction_details' => [
                    'order_id'     => (string) $transaction->transaction_code,
                    'gross_amount' => (int) round($payAmount),
                ],
                'customer_details' => [
                    'first_name' => (string) (auth()->user()->name ?? 'User Pembeli'),
                    'email'      => (string) (auth()->user()->email ?? 'pembeli@test.com'),
                ],
            ];

            $snapToken = \Midtrans\Snap::getSnapToken($params);

            $transaction->load('installments');

            return view('pages.transaction', compact(
                'transaction', 'property', 'snapToken', 'project', 'total_booking',
                'installmentData', 'installmentPlan', 'installmentOptions'
            ));
        } catch (\Exception $e) {
            return redirect()->back()->with('error', 'Gagal menghubungkan ke gerbang pembayaran. Silakan coba lagi.');
        }
    }

    public function callback(Request $request)
    {
        $serverKey = config('services.midtrans.server_key');
        $hashed = hash("sha512", $request->order_id . $request->status_code . $request->gross_amount . $serverKey);

        if ($hashed !== $request->signature_key) {
            return response()->json(['status' => 'invalid signature'], 403);
        }

        $orderId = $request->order_id;

        if (str_contains($orderId, '-LUNAS-')) {
            $parts = explode('-LUNAS-', $orderId);
            $transaction = Transaction::where('transaction_code', $parts[0])->first();
            if (!$transaction) {
                return response()->json(['status' => 'transaction not found'], 404);
            }
            $transactionStatus = $request->transaction_status;
            $fraudStatus = $request->fraud_status;
            if (in_array($transactionStatus, ['capture', 'settlement'])) {
                if ($transactionStatus === 'capture' && $fraudStatus !== 'accept') {
                    return response()->json(['status' => 'fraud detected']);
                }
                $transaction->update([
                    'payment_status' => 'success',
                    'amount_paid' => $transaction->gross_amount,
                ]);
                $property = Property::find($transaction->property_id);
                if ($property && $property->status !== 'sold') {
                    $property->update(['status' => 'sold']);
                }
            } elseif (in_array($transactionStatus, ['deny', 'cancel', 'expire'])) {
                $transaction->update(['payment_status' => 'failed']);
            }
            return response()->json(['status' => 'ok']);
        }

        if (str_contains($orderId, '-CICILAN-')) {
            $parts = explode('-CICILAN-', $orderId);
            $transactionCode = $parts[0];
            $installmentNumber = explode('-', $parts[1])[0];

            $transaction = Transaction::where('transaction_code', $transactionCode)->first();
            if (!$transaction) {
                return response()->json(['status' => 'transaction not found'], 404);
            }

            $installment = Installment::where('transaction_id', $transaction->id)
                ->where('installment_number', $installmentNumber)
                ->first();

            if (!$installment) {
                return response()->json(['status' => 'installment not found'], 404);
            }

            $transactionStatus = $request->transaction_status;
            $fraudStatus = $request->fraud_status;

            if (in_array($transactionStatus, ['capture', 'settlement'])) {
                if ($transactionStatus === 'capture' && $fraudStatus !== 'accept') {
                    return response()->json(['status' => 'fraud detected']);
                }

                $alreadyPaid = $installment->payment_status === 'success';

                $installment->update([
                    'payment_status' => 'success',
                    'paid_amount' => $installment->amount,
                    'paid_at' => now(),
                ]);

                if (!$alreadyPaid) {
                    $transaction->increment('paid_installments');
                    $transaction->increment('amount_paid', $installment->amount);
                }

                if ($transaction->paid_installments >= $transaction->installment_count) {
                    $transaction->update(['payment_status' => 'success']);
                    $property = Property::find($transaction->property_id);
                    if ($property && $property->status !== 'sold') {
                        $property->update(['status' => 'sold']);
                    }
                }
            } elseif (in_array($transactionStatus, ['deny', 'cancel', 'expire'])) {
                $installment->update(['payment_status' => 'failed']);
            } elseif ($transactionStatus == 'pending') {
                $installment->update(['payment_status' => 'pending']);
            }

            return response()->json(['status' => 'ok']);
        }

        $transaction = Transaction::where('transaction_code', $request->order_id)->first();
        if (!$transaction) {
            return response()->json(['status' => 'transaction not found'], 404);
        }

        $transactionStatus = $request->transaction_status;
        $fraudStatus = $request->fraud_status;

        $newStatus = $transaction->payment_type === 'booking' ? 'booking_paid' : 'success';

        if ($transactionStatus == 'capture') {
            if ($fraudStatus == 'accept') {
                $transaction->update([
                    'payment_status' => $newStatus,
                    'amount_paid' => $transaction->gross_amount,
                ]);
                if ($transaction->is_installment && $transaction->installment_count > 1) {
                    $firstInstallment = $transaction->installments()
                        ->where('installment_number', 1)
                        ->where('payment_status', '!=', 'success')
                        ->first();
                    if ($firstInstallment) {
                        $firstInstallment->update([
                            'payment_status' => 'success',
                            'paid_amount' => $firstInstallment->amount,
                            'paid_at' => now(),
                        ]);
                        $transaction->increment('paid_installments');
                    }
                }
            }
        } elseif ($transactionStatus == 'settlement') {
            $transaction->update([
                'payment_status' => $newStatus,
                'amount_paid' => $transaction->gross_amount,
            ]);
            if ($transaction->is_installment && $transaction->installment_count > 1) {
                $firstInstallment = $transaction->installments()
                    ->where('installment_number', 1)
                    ->where('payment_status', '!=', 'success')
                    ->first();
                if ($firstInstallment) {
                    $firstInstallment->update([
                        'payment_status' => 'success',
                        'paid_amount' => $firstInstallment->amount,
                        'paid_at' => now(),
                    ]);
                    $transaction->increment('paid_installments');
                }
            }
        } elseif (in_array($transactionStatus, ['deny', 'cancel', 'expire'])) {
            $transaction->update(['payment_status' => 'failed']);
        } elseif ($transactionStatus == 'pending') {
            $transaction->update(['payment_status' => 'pending']);
        }

        if ($transaction->payment_status === 'success' && !$transaction->is_installment) {
            $property = Property::find($transaction->property_id);
            if ($property && $property->status !== 'sold') {
                $property->update(['status' => 'sold']);
            }
        }

        return response()->json(['status' => 'ok']);
    }

    public function setSuccessInstantly($id)
{
    $transaction = \App\Models\Transaction::find($id);

    if (!$transaction) {
        return response()->json([
            'status'  => 'error',
            'message' => 'Transaksi tidak ditemukan.'
        ], 404);
    }

    if ($transaction->user_id !== Auth::id() && Auth::user()?->role !== 'admin') {
        return response()->json([
            'status'  => 'error',
            'message' => 'Anda tidak memiliki akses ke transaksi ini.'
        ], 403);
    }

    if ($transaction->is_installment && $transaction->installment_count > 1) {
        $installmentId = request('installment_id');
        $installment = null;

        if ($installmentId) {
            $installment = Installment::where('id', $installmentId)
                ->where('transaction_id', $transaction->id)
                ->where('payment_status', '!=', 'success')
                ->first();
        } else {
            $installment = $transaction->installments()
                ->where('payment_status', '!=', 'success')
                ->oldest('installment_number')
                ->first();
        }

        if ($installment) {
            $installment->update([
                'payment_status' => 'success',
                'paid_amount' => $installment->amount,
                'paid_at' => now(),
            ]);
            $transaction->increment('paid_installments');
            $transaction->increment('amount_paid', $installment->amount);

            if ($transaction->paid_installments >= $transaction->installment_count) {
                $transaction->update(['payment_status' => 'success']);
                $property = \App\Models\Property::find($transaction->property_id);
                if ($property && $property->status !== 'sold') {
                    $property->update(['status' => 'sold']);
                }
            }
        }

        return response()->json([
            'status'  => 'success',
            'message' => 'Pembayaran cicilan berhasil dikonfirmasi!'
        ]);
    }

    $newStatus = $transaction->payment_type === 'booking' ? 'booking_paid' : 'success';

    $transaction->update([
        'payment_status' => $newStatus,
        'amount_paid'    => $transaction->gross_amount
    ]);

    if ($newStatus === 'success') {
        $property = \App\Models\Property::find($transaction->property_id);
        if ($property && $property->status !== 'sold') {
            $property->update(['status' => 'sold']);
        }
    }

    return response()->json([
        'status'  => 'success',
        'message' => 'Pembayaran berhasil diperbarui langsung!'
    ]);
}

    public function pelunasan($id)
    {
        $transaction = Transaction::where('user_id', Auth::id())->findOrFail($id);

        if ($transaction->payment_status !== 'booking_paid') {
            return redirect()->route('dashboard')->with('error', 'Transaksi ini tidak memerlukan pelunasan.');
        }

        $property = Property::find($transaction->property_id);
        $bookingFee = config('payment.booking_fee');
        $sisa = $property->price - $bookingFee;

        return view('pages.pelunasan', compact('transaction', 'property', 'sisa'));
    }

    public function processPelunasan(Request $request, $id)
    {
        $request->validate([
            'metode' => 'required|in:cash,cicilan',
            'installment' => 'sometimes|in:none,monthly,quarterly,semi_annually',
        ]);

        $transaction = Transaction::where('user_id', Auth::id())->findOrFail($id);

        if ($transaction->payment_status !== 'booking_paid') {
            return redirect()->route('dashboard')->with('error', 'Transaksi ini tidak memerlukan pelunasan.');
        }

        $property = Property::find($transaction->property_id);
        $bookingFee = config('payment.booking_fee');
        $sisa = $property->price - $bookingFee;

        $metode = $request->metode;
        $installmentPlan = $request->get('installment', 'none');

        if ($metode === 'cash') {
            $transaction->update([
                'payment_type' => 'cash',
                'gross_amount' => $sisa,
                'total_payable' => $sisa,
                'installment_plan' => 'none',
                'installment_count' => 1,
                'installment_period_months' => 1,
                'service_fee' => 0,
                'installment_total' => 0,
            ]);
            $payAmount = $sisa;
        } else {
            $dpAmount = $sisa * config('payment.dp_rate');
            $installmentData = InstallmentService::calculate($sisa, $installmentPlan);
            $transaction->update([
                'payment_type' => 'dp',
                'gross_amount' => $sisa,
                'total_payable' => $sisa,
                'installment_plan' => $installmentPlan,
                'installment_count' => $installmentData['installment_count'],
                'installment_period_months' => $installmentData['installment_period_months'],
                'service_fee' => $installmentData['service_fee'],
                'installment_total' => $installmentData['total_with_fee'],
                'paid_installments' => 0,
            ]);

            if ($installmentData['installment_count'] > 1) {
                $transaction->installments()->delete();
                $dueDates = InstallmentService::getDueDates($installmentPlan, $installmentData['installment_count']);
                foreach ($dueDates as $i => $dueDate) {
                    \App\Models\Installment::create([
                        'transaction_id' => $transaction->id,
                        'installment_number' => $i + 1,
                        'amount' => $installmentData['per_installment'],
                        'paid_amount' => 0,
                        'due_date' => $dueDate,
                        'payment_status' => 'pending',
                    ]);
                }
            }

            $payAmount = $installmentData['installment_count'] > 1
                ? $installmentData['per_installment']
                : $installmentData['total_with_fee'];
        }

        $orderId = $transaction->transaction_code . '-LUNAS-' . time();

        $params = [
            'transaction_details' => [
                'order_id' => (string) $orderId,
                'gross_amount' => (int) round($payAmount),
            ],
            'customer_details' => [
                'first_name' => (string) (auth()->user()->name ?? 'User Pembeli'),
                'email' => (string) (auth()->user()->email ?? 'pembeli@test.com'),
            ],
        ];

        try {
            $snapToken = \Midtrans\Snap::getSnapToken($params);
            $transaction->load('installments');
            $totalBayar = $payAmount;
            $installmentData = $installmentData ?? null;
            return view('pages.pelunasan-pay', compact(
                'transaction', 'property', 'snapToken', 'totalBayar', 'metode', 'installmentPlan', 'installmentData'
            ));
        } catch (\Exception $e) {
            return redirect()->back()->with('error', 'Gagal menghubungkan ke gerbang pembayaran. Silakan coba lagi.');
        }
    }

    public function invoice($id)
    {
        $transaction = Transaction::where('user_id', Auth::id())->findOrFail($id);
        $property = Property::find($transaction->property_id);
        return view('pages.invoice', compact('transaction', 'property'));
    }

    public function downloadInvoice($id)
{
    $transaction = Transaction::where('user_id', Auth::id())->findOrFail($id);
    $property = Property::find($transaction->property_id);

    if ($transaction->payment_status !== 'success') {
        return redirect()->back()->with('error', 'Invoice belum bisa diunduh.');
    }

    // SEKARANG KITA ARAHKAN KE TEMPLATE KHUSUS PDF YANG BARU
    $pdf = Pdf::loadView('exports.invoice_pdf', compact('transaction', 'property'));

    return $pdf->download($transaction->transaction_code . '.pdf');
    }

}
