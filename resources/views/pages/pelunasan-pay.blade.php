@extends('layouts.app')

@section('title', 'Bayar Pelunasan - White House Premiere')

@section('content')
<div class="min-h-screen bg-gray-50 py-12">
    <div class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8">

        <div class="bg-white rounded-lg shadow-lg overflow-hidden">
            <div class="bg-blue-600 px-6 py-4">
                <h1 class="text-2xl font-bold text-white">Selesaikan Pelunasan</h1>
            </div>

            <div class="p-6">
                <div class="grid grid-cols-1 md:grid-cols-2 gap-8">

                    <div>
                        <h2 class="text-xl font-semibold text-gray-900 mb-4">Rincian Pelunasan</h2>
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
                                <span class="text-gray-600">Metode:</span>
                                <span class="px-2 py-0.5 text-xs font-bold rounded-full bg-blue-100 text-blue-800 uppercase">
                                    {{ $metode === 'cash' ? 'CASH' : 'CICILAN' }}
                                </span>
                            </div>

                            @if($metode === 'cicilan' && $installmentPlan !== 'none' && isset($installmentData))
                            <div class="flex justify-between text-sm">
                                <span class="text-gray-600">Rencana Cicilan:</span>
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

                            <hr class="my-3" style="border-top: 1px dashed #cbd5e0;">

                            <div class="flex justify-between text-sm">
                                <span class="text-gray-600">Harga Properti:</span>
                                <span class="text-gray-800">Rp {{ number_format($property->price, 0, ',', '.') }}</span>
                            </div>
                            <div class="flex justify-between text-sm">
                                <span class="text-gray-600">Sudah Dibayar (Booking):</span>
                                <span class="text-green-600 font-medium">Rp {{ number_format(config('payment.booking_fee'), 0, ',', '.') }}</span>
                            </div>

                            @if($metode === 'cicilan' && isset($installmentData))
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
                                <span>Total Dibayar:</span>
                                <span class="text-success">Rp {{ number_format($totalBayar, 0, ',', '.') }}</span>
                            </div>
                            @endif
                        </div>
                    </div>

                    <div class="flex flex-col justify-center items-center p-6 bg-gray-50 rounded-lg border border-gray-200">
                        <p class="text-sm text-gray-500 text-center mb-4">
                            Klik tombol di bawah ini untuk membuka metode pembayaran.
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
