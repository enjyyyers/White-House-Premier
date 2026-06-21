@extends('layouts.app')

@section('title', 'Selesaikan Pembayaran Anda')

@section('content')
<div class="min-h-screen bg-gray-50 py-12">
    <div class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8">

        <div class="bg-white rounded-lg shadow-lg overflow-hidden">
            <div class="bg-blue-600 px-6 py-4">
                <h1 class="text-2xl font-bold text-white">Selesaikan Pembayaran Anda</h1>
            </div>

            <div class="p-6">
                <div class="grid grid-cols-1 md:grid-cols-2 gap-8">

                    <div>
                        <h2 class="text-xl font-semibold text-gray-900 mb-4">Rincian Pembayaran</h2>
                        <div class="space-y-3">

                            <div class="flex justify-between text-sm">
                                <span class="text-gray-600">Nama Properti:</span>
                                <span class="font-semibold text-gray-800 text-right">{{ $property->name }}</span>
                            </div>

                            <div class="flex justify-between text-sm">
                                <span class="text-gray-600">Kode Transaksi:</span>
                                <span class="font-bold text-blue-600">{{ $transaction->transaction_code }}</span>
                            </div>

                            <div class="flex justify-between text-sm">
                                <span class="text-gray-600">Metode Pembayaran:</span>
                                <span class="px-2 py-0.5 text-xs font-bold rounded-full bg-blue-100 text-blue-800 text-uppercase">
                                    {{ strtoupper($transaction->payment_type ?? 'booking') }}
                                </span>
                            </div>

                            @if($installmentPlan !== 'none')
                            <div class="flex justify-between text-sm">
                                <span class="text-gray-600">Cicilan:</span>
                                <span class="px-2 py-0.5 text-xs font-bold rounded-full bg-purple-100 text-purple-800">
                                    {{ $installmentData['label'] ?? strtoupper($installmentPlan) }}
                                </span>
                            </div>
                            <div class="flex justify-between text-sm">
                                <span class="text-gray-600">Jumlah Cicilan:</span>
                                <span class="font-semibold text-gray-800">{{ $installmentData['installment_count'] }}x</span>
                            </div>
                            <div class="flex justify-between text-sm">
                                <span class="text-gray-600">Biaya Jasa:</span>
                                <span class="font-medium text-amber-600">Rp {{ number_format($installmentData['service_fee'] ?? 0, 0, ',', '.') }}</span>
                            </div>
                            @endif

                            <div class="flex justify-between text-sm">
                                <span class="text-gray-600">Status Pembayaran:</span>
                                <span class="px-2 py-0.5 text-xs font-semibold rounded-full bg-yellow-100 text-yellow-800">
                                    {{ strtoupper($transaction->payment_status) }}
                                </span>
                            </div>

                            <hr class="my-3" style="border-top: 1px dashed #cbd5e0;">

                            <div class="flex justify-between text-sm">
                                <span class="text-gray-600">Harga Dasar Properti:</span>
                                <span class="text-gray-800">Rp {{ number_format($property->price, 0, ',', '.') }}</span>
                            </div>

                            <div class="flex justify-between text-sm">
                                <span class="text-gray-600">Nilai Pokok Transaksi:</span>
                                <span class="font-medium text-gray-800">Rp {{ number_format($project['price_raw'] ?? 0, 0, ',', '.') }}</span>
                            </div>

                            <div class="flex justify-between text-sm text-gray-600">
                                <span>Biaya IPL (20% dari Pokok):</span>
                                <span class="text-gray-800">+ Rp {{ number_format($project['ipl'] ?? 0, 0, ',', '.') }}</span>
                            </div>

                            <div class="flex justify-between text-sm text-gray-600">
                                <span>Pajak PPN (2% dari Pokok):</span>
                                <span class="text-gray-800">+ Rp {{ number_format($project['tax'] ?? 0, 0, ',', '.') }}</span>
                            </div>

                            <hr class="my-4">

                            @if($installmentPlan !== 'none')
                            <div class="flex justify-between text-lg font-bold">
                                <span>Total + Biaya Jasa:</span>
                                <span class="text-purple-600">Rp {{ number_format($installmentData['total_with_fee'] ?? 0, 0, ',', '.') }}</span>
                            </div>
                            <div class="flex justify-between text-base font-semibold text-blue-600 bg-blue-50 p-3 rounded-lg">
                                <span>Pembayaran Pertama:</span>
                                <span>Rp {{ number_format($installmentData['per_installment'] ?? 0, 0, ',', '.') }}</span>
                            </div>
                            @else
                            <div class="flex justify-between text-lg font-bold">
                                <span>Total Tagihan:</span>
                                <span class="text-success">Rp {{ number_format($total_booking, 0, ',', '.') }}</span>
                            </div>
                            @endif
                        </div>

                        @if($installmentPlan !== 'none' && ($installmentData['installment_count'] ?? 0) > 1)
                        <div class="mt-6 bg-gray-50 rounded-lg p-4 border border-gray-200">
                            <h3 class="font-bold text-gray-700 text-sm mb-3">Rencana Cicilan</h3>
                            <table class="w-full text-xs">
                                <thead>
                                    <tr class="text-gray-500 border-b border-gray-200">
                                        <th class="py-2 text-left">#</th>
                                        <th class="py-2 text-left">Jatuh Tempo</th>
                                        <th class="py-2 text-right">Jumlah</th>
                                        <th class="py-2 text-right">Status</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach($transaction->installments ?? [] as $inst)
                                    <tr class="border-b border-gray-100">
                                        <td class="py-2">{{ $inst->installment_number }}</td>
                                        <td class="py-2">{{ \Carbon\Carbon::parse($inst->due_date)->format('d M Y') }}</td>
                                        <td class="py-2 text-right font-medium">Rp {{ number_format($inst->amount, 0, ',', '.') }}</td>
                                        <td class="py-2 text-right">
                                            @if($inst->payment_status === 'success')
                                            <span class="text-green-600 font-bold">Lunas</span>
                                            @elseif($inst->payment_status === 'failed')
                                            <span class="text-red-600 font-bold">Gagal</span>
                                            @else
                                            <span class="text-yellow-600">Menunggu</span>
                                            @endif
                                        </td>
                                    </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                        @endif
                    </div>

                    <div class="flex flex-col justify-center items-center p-6 bg-gray-50 rounded-lg border border-gray-200">
                        <p class="text-sm text-gray-500 text-center mb-4">
                            Klik tombol di bawah ini jika menu metode pembayaran aman via Midtrans tidak muncul secara otomatis.
                        </p>

                        <button id="pay-button" class="w-full bg-blue-600 text-white py-3 px-4 rounded-md hover:bg-blue-700 transition duration-200 focus:outline-none font-medium shadow-md">
                            Bayar Sekarang
                        </button>
                    </div>

                </div>
            </div>
        </div>
    </div>
</div>

<script type="text/javascript" src="https://app.sandbox.midtrans.com/snap/snap.js" data-client-key="{{ config('services.midtrans.client_key') }}"></script>

<script type="text/javascript">
    var snapToken = '{{ $snapToken }}';

    function triggerSnapPay() {
        if (typeof window.snap === 'undefined') {
            alert("Metode pembayaran belum siap. Silakan klik tombol bayar beberapa saat lagi.");
            return;
        }

        if (!snapToken || snapToken === '') {
            alert("Error Sistem: Token pembayaran tidak ditemukan. Silakan coba lagi.");
            return;
        }

        window.snap.pay(snapToken, {
            onSuccess: function(result) {
                aksiUpdateOtomatis();
            },
            onPending: function(result) {
                aksiUpdateOtomatis();
            },
            onError: function(result) {
                alert("Pembayaran gagal atau dibatalkan.");
            }
        });
    }

    function aksiUpdateOtomatis() {
        fetch("{{ url('/transaction/set-success') }}/{{ $transaction->id }}", {
            method: "POST",
            headers: {
                "X-CSRF-TOKEN": "{{ csrf_token() }}",
                "Content-Type": "application/json",
                "Accept": "application/json"
            }
        })
        .then(response => response.json())
        .then(data => {
            alert("Sistem: Pembayaran Berhasil Dikonfirmasi!");
            window.location.href = "{{ route('dashboard') }}";
        })
        .catch(error => {
            console.error("Error AJAX:", error);
            window.location.href = "{{ route('dashboard') }}";
        });
    }

    document.addEventListener('DOMContentLoaded', function() {
        var payButton = document.getElementById('pay-button');
        if (payButton) {
            payButton.addEventListener('click', function (e) {
                e.preventDefault();
                triggerSnapPay();
            });
        }

        var checkSnap = setInterval(function() {
            if (typeof window.snap !== 'undefined') {
                clearInterval(checkSnap);
                setTimeout(triggerSnapPay, 500);
            }
        }, 200);

        setTimeout(function() {
            clearInterval(checkSnap);
        }, 10000);
    });
</script>
@endsection
