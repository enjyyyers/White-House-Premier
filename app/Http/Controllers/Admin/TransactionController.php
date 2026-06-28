<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Exports\TransactionExport;
use Illuminate\Http\Request;
use App\Models\Transaction;
use App\Models\Property;
use Maatwebsite\Excel\Facades\Excel;

class TransactionController extends Controller
{
    /**
     * Menampilkan semua daftar transaksi dengan fitur filter Tab & Analytics Dashboard
     */
    public function index(Request $request)
    {
        // 1. Tangkap parameter tab dari URL (default ke 'all' jika baru buka halaman)
        $tab = $request->query('tab', 'all');

        // 2. Query dasar mengambil data transaksi beserta relasi user & properti
        $query = Transaction::with(['user', 'property'])->orderBy('created_at', 'desc');

        // 3. Filter data berdasarkan tab yang sedang aktif (booking, dp, cash)
        if ($tab !== 'all') {
            $query->where('payment_type', $tab);
        }

        // Ambil data transaksi hasil filter
        $transactions = $query->get();

        // 4. HITUNG DATA ANALYTICS (Hanya menghitung transaksi yang bernilai 'success')
        $analytics = [
            'total_revenue' => Transaction::where('payment_status', 'success')->sum('total_payable'),
            'booking_count' => Transaction::where('payment_type', 'booking')->where('payment_status', 'success')->count(),
            'dp_count'      => Transaction::where('payment_type', 'dp')->where('payment_status', 'success')->count(),
            'cash_count'    => Transaction::where('payment_type', 'cash')->where('payment_status', 'success')->count(),
        ];

        // 5. Kirim semua variabel ke view
        return view('admin.transaction.index', compact('transactions', 'analytics', 'tab'));
    }

    /**
     * Menampilkan halaman detail satu transaksi tertentu dengan hitungan breakdown matematika
     */
    public function show($id)
    {
        $transaction = Transaction::with(['user', 'installments'])->findOrFail($id);
        $property = Property::find($transaction->property_id);

        // LOGIKA MATEMATIKA: Memecah komponen harga agar sinkron dengan Kasir & Invoice PDF
        $tipe = $transaction->payment_type ?? 'booking';
        $propPrice = $transaction->property_price ?? ($property->price ?? 0);

        if ($tipe === 'booking') {
            $price_raw = config('payment.booking_fee');
            $admin = 0;
            $tax = 0;
        } elseif ($tipe === 'dp') {
            $price_raw = $propPrice * config('payment.dp_rate');
            $admin = $propPrice * config('payment.admin_rate');
            $tax = $propPrice * config('payment.tax_rate');
        } else {
            $price_raw = $propPrice;
            $admin = $propPrice * config('payment.admin_rate');
            $tax = $propPrice * config('payment.tax_rate');
        }

        $installmentOptions = \App\Services\InstallmentService::plans();

        return view('admin.transaction.show', compact(
            'transaction', 'property', 'price_raw', 'admin', 'tax', 'installmentOptions'
        ));
    }

    /**
     * Mengubah status pembayaran & tipe transaksi secara manual oleh Admin (Edit Data)
     */
    public function updateStatus(Request $request, $id)
    {
        $request->validate([
            'payment_status' => 'required|in:pending,success,failed,expired',
            'payment_type'   => 'required|in:booking,dp,cash',
            'installment_plan' => 'sometimes|in:none,monthly,quarterly,semi_annually',
        ]);
        $newInstallmentPlan = $request->get('installment_plan', 'none');

        $transaction = Transaction::findOrFail($id);
        $property = Property::find($transaction->property_id);

        $oldStatus = $transaction->payment_status;
        $newStatus = $request->payment_status;
        $newType   = $request->payment_type;

        // Hitung ulang gross_amount & total_payable jika Admin mengganti mekanisme pembayaran
        $propPrice = $transaction->property_price ?? ($property->price ?? 0);

        if ($newType === 'booking') {
            $price_raw = config('payment.booking_fee');
            $admin = 0;
            $tax_calculated = 0;
        } elseif ($newType === 'dp') {
            $price_raw = $propPrice * config('payment.dp_rate');
            $admin = $propPrice * config('payment.admin_rate');
            $tax_calculated = $propPrice * config('payment.tax_rate');
        } else {
            $price_raw = $propPrice;
            $admin = $propPrice * config('payment.admin_rate');
            $tax_calculated = $propPrice * config('payment.tax_rate');
        }

        $total_baru = $price_raw + $admin + $tax_calculated;

        $updateData = [
            'payment_status' => $newStatus,
            'payment_type'   => $newType,
            'tax_amount'     => $tax_calculated,
            'gross_amount'   => $total_baru,
            'total_payable'  => $total_baru,
        ];

            // Handle installment plan changes
            if (in_array($newType, ['booking', 'dp']) && $newInstallmentPlan !== 'none' && $newInstallmentPlan !== '') {
            $installmentData = \App\Services\InstallmentService::calculate($total_baru, $newInstallmentPlan);
            $updateData['installment_plan'] = $newInstallmentPlan;
            $updateData['installment_period_months'] = $installmentData['installment_period_months'];
            $updateData['installment_count'] = $installmentData['installment_count'];
            $updateData['service_fee'] = $installmentData['service_fee'];
            $updateData['installment_total'] = $installmentData['total_with_fee'];

            // Create installment records
            $transaction->installments()->delete();
            $dueDates = \App\Services\InstallmentService::getDueDates($newInstallmentPlan, $installmentData['installment_count']);
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
        } elseif ($newInstallmentPlan === 'none') {
            $updateData['installment_plan'] = 'none';
            $updateData['installment_period_months'] = 1;
            $updateData['installment_count'] = 1;
            $updateData['service_fee'] = 0;
            $updateData['installment_total'] = 0;
            $transaction->installments()->delete();
        }

        // Update data transaksi secara menyeluruh
        $transaction->update($updateData);

        // SINKRONISASI STATUS UNIT RUMAH KE TABEL PROPERTI
        if ($newStatus === 'success' && $oldStatus !== 'success') {
            // Jika status lunas -> Ubah status unit rumah jadi terjual ('sold')
            if ($property) {
                $property->update(['status' => 'sold']);
            }
        } elseif (in_array($newStatus, ['failed', 'expired']) && $oldStatus === 'success') {
            // Jika dibatalkan/gagal -> Kembalikan unit menjadi kosong kembali
            if ($property) {
                $property->update(['status' => 'available']);
            }
        }

        return redirect()->back()->with('success', 'Data rincian transaksi berhasil diperbarui.');
    }

    /**
     * Menghapus riwayat transaksi dari database
     */
    public function destroy($id)
    {
        $transaction = Transaction::findOrFail($id);
        $transaction->delete();

        return redirect()->route('admin.transaction.index')->with('success', 'Data transaksi berhasil dihapus dari sistem.');
    }

    public function exportExcel(Request $request)
    {
        $tab = $request->query('tab', 'all');
        $filename = 'laporan-penjualan-' . now()->format('YmdHis') . '.xlsx';
        return Excel::download(new TransactionExport($tab), $filename);
    }
}
