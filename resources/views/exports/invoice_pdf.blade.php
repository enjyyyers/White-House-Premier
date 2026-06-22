<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title>Invoice - {{ $transaction->transaction_code }}</title>
    <style>
        body { font-family: 'Helvetica Neue', 'Helvetica', Helvetica, Arial, sans-serif; color: #444; line-height: 1.4; }
        .invoice-box { max-width: 800px; margin: auto; padding: 20px; border: 1px solid #eee; box-shadow: 0 0 10px rgba(0, 0, 0, .15); font-size: 14px; }
        .invoice-box table { width: 100%; line-height: inherit; text-align: left; border-collapse: collapse; }
        .invoice-box table td { padding: 8px; vertical-align: top; }
        .invoice-box table tr td:nth-child(2) { text-align: right; }
        .invoice-box table tr.top table td { padding-bottom: 20px; }
        .invoice-box table tr.top table td.title { font-size: 30px; line-height: 30px; color: #1e3a8a; font-weight: bold; }
        .invoice-box table tr.information table td { padding-bottom: 30px; }
        .invoice-box table tr.heading td { background: #f3f4f6; border-bottom: 1px solid #ddd; font-weight: bold; color: #1f2937; }
        .invoice-box table tr.details td { padding-bottom: 15px; }
        .invoice-box table tr.item td { border-bottom: 1px solid #eee; }
        .invoice-box table tr.total td:nth-child(2) { border-top: 2px solid #1e3a8a; font-weight: bold; font-size: 16px; color: #1e3a8a; padding-top: 15px; }
        .status-badge { background-color: #10b981; color: white; padding: 3px 8px; border-radius: 4px; font-size: 12px; font-weight: bold; display: inline-block; }
    </style>
</head>
<body>
    <div class="invoice-box">
        <table>
            <tr class="top">
                <td colspan="2">
                    <table>
                        <tr>
                            <td class="title">
                                WHITE HOUSE
                            </td>
                            <td>
                                <strong>INVOICE PEMBAYARAN</strong><br>
                                Nomor: {{ $transaction->transaction_code }}<br>
                                Tanggal: {{ $transaction->created_at->format('d F Y') }}
                            </td>
                        </tr>
                    </table>
                </td>
            </tr>

            <tr class="information">
                <td colspan="2">
                    <table>
                        <tr>
                            <td>
                                <strong>Diterbitkan Oleh:</strong><br>
                                PT White House Premiere<br>
                                Jl. Sudirman No. 123, Jakarta Pusat
                            </td>
                            <td>
                                <strong>Ditujukan Untuk:</strong><br>
                                {{ auth()->user()->name }}<br>
                                {{ auth()->user()->email }}
                            </td>
                        </tr>
                    </table>
                </td>
            </tr>

            <tr class="heading">
                <td>Metode Pembayaran</td>
                <td>Status</td>
            </tr>

            <tr class="details">
                <td>Midtrans Sandbox ({{ strtoupper($transaction->payment_type ?? 'booking') }})</td>
                <td><span class="status-badge">SUCCESS</span></td>
            </tr>

            <tr class="heading">
                <td>Deskripsi Rincian Properti & Biaya</td>
                <td>Subtotal</td>
            </tr>

            <tr class="item">
                <td><strong>Nama Properti:</strong> {{ $property->name ?? 'Unit Properti' }}</td>
                <td></td>
            </tr>

            <tr class="item">
                <td style="color: #666; padding-left: 15px;">Harga Dasar Rumah</td>
                <td>Rp {{ number_format($transaction->property_price, 0, ',', '.') }}</td>
            </tr>

            @php
                $tipe = $transaction->payment_type ?? 'booking';
                $propPrice = $transaction->property_price ?? 0;

                if ($tipe === 'booking') {
                    $nilai_pokok = config('payment.booking_fee');
                    $admin_calculated = 0;
                    $tax_calculated = 0;
                } elseif ($tipe === 'dp') {
                    $nilai_pokok = $propPrice * config('payment.dp_rate');
                    $admin_calculated = $propPrice * config('payment.admin_rate');
                    $tax_calculated = $propPrice * config('payment.tax_rate');
                } else {
                    $nilai_pokok = $propPrice;
                    $admin_calculated = $propPrice * config('payment.admin_rate');
                    $tax_calculated = $propPrice * config('payment.tax_rate');
                }
            @endphp

            <tr class="item">
                <td style="padding-left: 15px;">Nilai Pokok Tagihan (Metode: <strong>{{ strtoupper($tipe) }}</strong>)</td>
                <td class="font-weight-bold">Rp {{ number_format($nilai_pokok, 0, ',', '.') }}</td>
            </tr>

            @if($tipe !== 'booking')
            <tr class="item">
                <td style="color: #555; padding-left: 15px;">Biaya Administrasi (1%)</td>
                <td style="color: #dd6b20;">+ Rp {{ number_format($admin_calculated, 0, ',', '.') }}</td>
            </tr>

            <tr class="item">
                <td style="color: #555; padding-left: 15px;">PPN 11%</td>
                <td style="color: #dd6b20;">+ Rp {{ number_format($tax_calculated, 0, ',', '.') }}</td>
            </tr>
            @endif

            <tr class="total">
                <td></td>
                <td>Total Bayar Akhir: Rp {{ number_format($transaction->total_payable, 0, ',', '.') }}</td>
            </tr>
        </table>
    </div>
</body>
</html>
