@extends('layouts.app')

@section('title', 'Pelunasan Pembayaran - White House Premiere')

@section('content')
<div class="bg-gray-100 min-h-screen pt-24 pb-12">
    <div class="max-w-3xl mx-auto px-4 sm:px-6 lg:px-8">

        <div class="bg-white rounded-2xl shadow-sm border border-gray-200 overflow-hidden">
            <div class="bg-blue-600 px-6 py-5">
                <h1 class="text-xl font-bold text-white flex items-center gap-2">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/>
                    </svg>
                    Lanjutkan Pelunasan
                </h1>
            </div>

            <div class="p-6 space-y-6">
                <div class="bg-blue-50 rounded-xl p-4 border border-blue-100">
                    <div class="flex items-center gap-3">
                        <div class="w-12 h-12 rounded-full bg-blue-100 flex items-center justify-center text-blue-600">
                            <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6"/>
                            </svg>
                        </div>
                        <div>
                            <p class="text-sm text-blue-600 font-semibold">Properti</p>
                            <h3 class="font-bold text-gray-900 text-lg">{{ $property->name }}</h3>
                        </div>
                    </div>
                </div>

                <div class="grid grid-cols-2 gap-4">
                    <div class="bg-gray-50 rounded-xl p-4 border border-gray-100">
                        <p class="text-xs font-semibold text-gray-400 uppercase tracking-wider">Harga Properti</p>
                        <p class="text-xl font-bold text-gray-900 mt-1">Rp {{ number_format($property->price, 0, ',', '.') }}</p>
                    </div>
                    <div class="bg-gray-50 rounded-xl p-4 border border-gray-100">
                        <p class="text-xs font-semibold text-gray-400 uppercase tracking-wider">Sudah Dibayar (Booking)</p>
                        <p class="text-xl font-bold text-green-600 mt-1">Rp {{ number_format(config('payment.booking_fee'), 0, ',', '.') }}</p>
                    </div>
                </div>

                <div class="bg-amber-50 rounded-xl p-5 border border-amber-200">
                    <div class="flex justify-between items-center">
                        <div>
                            <p class="text-sm font-semibold text-amber-700 uppercase tracking-wider">Sisa yang Harus Dibayar</p>
                            <p class="text-xs text-amber-600 mt-0.5">(Harga Properti - Booking Fee)</p>
                        </div>
                        <p class="text-2xl font-black text-amber-800">Rp {{ number_format($sisa, 0, ',', '.') }}</p>
                    </div>
                </div>

                <hr class="border-gray-200">

                <div x-data="{ metode: 'cash', cicilan: 'none' }">
                    <h4 class="text-sm font-bold text-gray-700 mb-4">Pilih Metode Pelunasan</h4>

                    <div class="grid grid-cols-2 gap-3 mb-4">
                        <button @click="metode = 'cash'; cicilan = 'none'" type="button"
                                :class="metode === 'cash' ? 'bg-blue-600 text-white border-blue-600 shadow-md' : 'bg-white text-gray-700 border-gray-200 hover:border-blue-300'"
                                class="p-4 rounded-xl border-2 font-bold text-sm transition-all cursor-pointer text-center">
                            <svg class="w-6 h-6 mx-auto mb-1" :class="metode === 'cash' ? 'text-white' : 'text-gray-400'" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 9V7a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2m2 4h10a2 2 0 002-2v-6a2 2 0 00-2-2H9a2 2 0 00-2 2v6a2 2 0 002 2zm7-5a2 2 0 11-4 0 2 2 0 014 0z"/>
                            </svg>
                            Bayar Cash
                            <div class="text-[10px] font-normal mt-0.5 opacity-80">Bayar sisa sekaligus</div>
                        </button>
                        <button @click="metode = 'cicilan'; cicilan = 'quarterly'" type="button"
                                :class="metode === 'cicilan' ? 'bg-purple-600 text-white border-purple-600 shadow-md' : 'bg-white text-gray-700 border-gray-200 hover:border-purple-300'"
                                class="p-4 rounded-xl border-2 font-bold text-sm transition-all cursor-pointer text-center">
                            <svg class="w-6 h-6 mx-auto mb-1" :class="metode === 'cicilan' ? 'text-white' : 'text-gray-400'" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"/>
                            </svg>
                            Bayar Cicilan
                            <div class="text-[10px] font-normal mt-0.5 opacity-80">Cicil sisa pembayaran</div>
                        </button>
                    </div>

                    <div x-show="metode === 'cicilan'" x-cloak class="mb-4">
                        <h5 class="text-xs font-bold uppercase tracking-wider text-gray-400 mb-2">Pilih Jangka Cicilan</h5>
                        <div class="grid grid-cols-3 gap-2">
                            <button @click="cicilan = 'monthly'" type="button"
                                    :class="cicilan === 'monthly' ? 'bg-purple-600 text-white shadow-sm' : 'bg-gray-50 text-gray-600 hover:bg-gray-100'"
                                    class="py-3 text-xs font-bold rounded-lg border border-gray-200 transition-all cursor-pointer">
                                1 Bulan (1x)
                            </button>
                            <button @click="cicilan = 'quarterly'" type="button"
                                    :class="cicilan === 'quarterly' ? 'bg-purple-600 text-white shadow-sm' : 'bg-gray-50 text-gray-600 hover:bg-gray-100'"
                                    class="py-3 text-xs font-bold rounded-lg border border-gray-200 transition-all cursor-pointer">
                                3 Bulan (3x + 2%)
                            </button>
                            <button @click="cicilan = 'semi_annually'" type="button"
                                    :class="cicilan === 'semi_annually' ? 'bg-purple-600 text-white shadow-sm' : 'bg-gray-50 text-gray-600 hover:bg-gray-100'"
                                    class="py-3 text-xs font-bold rounded-lg border border-gray-200 transition-all cursor-pointer">
                                6 Bulan (6x + 3.5%)
                            </button>
                        </div>
                    </div>

                    <form :action="metode === 'cash'
                        ? '{{ route('transaction.pelunasan.process', $transaction->id) }}'
                        : '{{ route('transaction.pelunasan.process', $transaction->id) }}'" method="POST">
                        @csrf
                        <input type="hidden" name="metode" x-model="metode">
                        <input type="hidden" name="installment" x-model="cicilan">

                        <button type="submit"
                                class="w-full mt-4 bg-blue-600 hover:bg-blue-700 text-white font-bold py-4 rounded-xl transition-all shadow-lg shadow-blue-200 flex items-center justify-center text-sm">
                            <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 7l5 5m0 0l-5 5m5-5H6"/>
                            </svg>
                            Lanjutkan Pembayaran
                        </button>
                    </form>
                </div>
            </div>
        </div>

    </div>
</div>
@endsection
