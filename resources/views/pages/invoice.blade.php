@extends('layouts.app')

@section('content')
<style>
    /* Syntax untuk merapikan hasil cetak */
    @media print {
        /* 1. Sembunyikan elemen yang tidak perlu (Navbar, Footer, Tombol) */
        nav,
        footer,
        .bg-gray-50.p-6.text-center.border-t, /* Footer bawaan invoice */
        .mt-8.grid.grid-cols-2.gap-4 { /* Container tombol */
            display: none !important;
        }

        /* 2. Bersihkan layout halaman */
        body {
            background-color: white !important;
            margin: 0;
            padding: 0;
        }

        .py-12 {
            padding-top: 0 !important;
            padding-bottom: 0 !important;
        }

        /* 3. Hilangkan bayangan dan border agar terlihat seperti dokumen resmi */
        .shadow-lg {
            box-shadow: none !important;
        }

        .max-w-3xl {
            max-width: 100% !important;
            width: 100% !important;
            margin: 0 !important;
        }

        /* 4. Atur margin kertas */
        @page {
            margin: 1.5cm;
        }
    }
</style>

<div class="py-12 bg-gray-100 min-h-screen">
    <div class="max-w-3xl mx-auto bg-white rounded-xl shadow-lg overflow-hidden">
        <div class="bg-gradient-to-r from-blue-600 to-blue-700 p-8 text-white flex justify-between items-center">
            <div>
                <h1 class="text-2xl font-bold">INVOICE PEMBAYARAN</h1>
                <p class="text-blue-100">No: {{ $transaction->invoice_number }}</p>
            </div>
            <div class="text-right">
                @php
                    $statusBg = match($transaction->status) {
                        'PENDING' => 'bg-yellow-400 text-yellow-900',
                        'SUCCESS' => 'bg-green-400 text-green-900',
                        'FAILED' => 'bg-red-400 text-red-900',
                        default => 'bg-gray-400 text-gray-900'
                    };
                @endphp
                <span class="px-4 py-2 {{ $statusBg }} rounded-full font-bold text-sm">
                    {{ $transaction->status }}
                </span>
            </div>
        </div>

        <div class="p-8">
            <div class="grid grid-cols-2 gap-8 mb-8 pb-8 border-b border-gray-200">
                <div>
                    <p class="text-gray-500 text-sm uppercase font-semibold mb-2">Ditujukan Untuk:</p>
                    <p class="font-bold text-gray-900 text-lg">{{ $transaction->buyer_name }}</p>
                    <p class="text-gray-600">{{ $transaction->buyer_email }}</p>
                    <p class="text-gray-600">{{ $transaction->buyer_phone }}</p>
                </div>
                <div class="text-right">
                    <p class="text-gray-500 text-sm uppercase font-semibold mb-2">Tanggal Transaksi:</p>
                    <p class="font-bold text-gray-900 text-lg">{{ $transaction->created_at->format('d M Y') }}</p>
                    <p class="text-gray-600">{{ $transaction->created_at->format('H:i') }} WIB</p>
                </div>
            </div>

            <div class="mb-8">
                <h3 class="font-bold text-gray-900 text-lg mb-4">Detail Transaksi</h3>
                <table class="w-full">
                    <thead>
                        <tr class="border-b-2 border-gray-300 text-left">
                            <th class="py-3 text-gray-600 font-semibold">Deskripsi</th>
                            <th class="py-3 text-right text-gray-600 font-semibold">Nominal</th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr class="border-b border-gray-200">
                            <td class="py-4 font-semibold text-gray-900">{{ $transaction->project_name }}</td>
                            <td class="py-4 text-right text-gray-900">{{ $transaction->formatted_amount }}</td>
                        </tr>
                        <tr>
                            <td class="py-4 font-bold text-lg text-gray-900">Total Biaya Fixed</td>
                            <td class="py-4 text-right font-black text-blue-600 text-2xl">
                                {{ $transaction->formatted_amount }}
                            </td>
                        </tr>
                    </tbody>
                </table>
            </div>

            <div class="bg-gray-50 p-6 rounded-xl border border-dashed border-gray-300">
                <h4 class="font-bold text-gray-900 mb-3 text-center">PETUNJUK PEMBAYARAN</h4>
                <div class="space-y-2 text-center">
                    <p class="text-sm text-gray-600">Silakan transfer tepat sesuai nominal ke:</p>
                    <div class="bg-white p-4 rounded-lg mt-4">
                        <p class="text-lg font-bold text-gray-900">{{ $transaction->bank_name }}</p>
                        <p class="text-2xl font-black text-blue-600 my-2">{{ $transaction->account_number }}</p>
                        <p class="text-sm text-gray-500">A.n PT White House Premiere</p>
                    </div>
                    <p class="text-xs text-gray-500 mt-4">
                        <i class="fas fa-info-circle"></i>
                        Status pembayaran akan otomatis terupdate setelah kami menerima transfer Anda.
                    </p>
                </div>
            </div>

            <div class="mt-8 grid grid-cols-2 gap-4">
                <button onclick="window.print()" class="bg-gray-200 hover:bg-gray-300 text-gray-700 font-bold py-3 rounded-lg transition">
                    <i class="fas fa-print mr-2"></i> Cetak Invoice
                </button>
                <a href="{{ route('dashboard') }}" class="bg-blue-600 hover:bg-blue-700 text-white text-center font-bold py-3 rounded-lg transition">
                    <i class="fas fa-arrow-left mr-2"></i> Kembali ke Dashboard
                </a>
            </div>
        </div>

        <div class="bg-gray-50 p-6 text-center border-t border-gray-200">
            <p class="text-gray-500 text-sm">
                Terima kasih telah mempercayakan kepada <span class="font-bold">White House Premiere</span>
            </p>
        </div>
    </div>
</div>
@endsection
