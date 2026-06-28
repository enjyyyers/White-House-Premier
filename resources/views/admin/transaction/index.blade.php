@extends('layouts.admin')

@section('title', 'Transaksi')
@section('subtitle', 'Pantau semua transaksi properti yang masuk.')

@section('content')
<div class="p-6">

    <div class="grid grid-cols-1 md:grid-cols-4 gap-6 mb-8">
        <div class="bg-white p-6 rounded-xl shadow-sm border border-gray-100">
            <p class="text-xs font-semibold text-gray-400 uppercase mb-2">Total Pendapatan</p>
            <h3 class="text-2xl font-bold text-blue-600">Rp {{ number_format($analytics['total_revenue'], 0, ',', '.') }}</h3>
        </div>
        <div class="bg-white p-6 rounded-xl shadow-sm border border-gray-100">
            <p class="text-xs font-semibold text-gray-400 uppercase mb-2">Booking</p>
            <h3 class="text-2xl font-bold text-gray-800">{{ $analytics['booking_count'] }} <span class="text-sm font-normal text-gray-400">Unit</span></h3>
        </div>
        <div class="bg-white p-6 rounded-xl shadow-sm border border-gray-100">
            <p class="text-xs font-semibold text-gray-400 uppercase mb-2">DP (20%)</p>
            <h3 class="text-2xl font-bold text-gray-800">{{ $analytics['dp_count'] }} <span class="text-sm font-normal text-gray-400">Unit</span></h3>
        </div>
        <div class="bg-white p-6 rounded-xl shadow-sm border border-gray-100">
            <p class="text-xs font-semibold text-gray-400 uppercase mb-2">Full Cash</p>
            <h3 class="text-2xl font-bold text-gray-800">{{ $analytics['cash_count'] }} <span class="text-sm font-normal text-gray-400">Unit</span></h3>
        </div>
    </div>

    <div class="bg-white rounded-xl shadow-sm border border-gray-100 overflow-hidden">
        <div class="flex items-center justify-between border-b border-gray-100">
            <div class="flex">
                @foreach(['all' => 'Semua', 'booking' => 'Booking Fee', 'dp' => 'DP (20%)', 'cash' => 'Full Cash'] as $key => $label)
                    <a href="{{ route('admin.transaction.index', ['tab' => $key]) }}"
                       class="px-6 py-4 text-sm font-medium transition {{ $tab == $key ? 'text-blue-600 border-b-2 border-blue-600 bg-blue-50/50' : 'text-gray-500 hover:bg-gray-50' }}">
                        {{ $label }}
                    </a>
                @endforeach
            </div>
            <div class="px-4">
                <a href="{{ route('admin.transaction.excel', ['tab' => $tab]) }}"
                   class="flex items-center px-4 py-2 bg-emerald-600 text-white rounded-lg text-sm font-medium hover:bg-emerald-700 transition-colors">
                    <i class="fas fa-file-excel mr-2"></i> Export Excel
                </a>
            </div>
        </div>

        <div class="overflow-x-auto">
            <table class="w-full text-left">
                <thead class="bg-gray-50">
                    <tr>
                        <th class="px-6 py-4 text-xs font-bold text-gray-400 uppercase">Pelanggan</th>
                        <th class="px-6 py-4 text-xs font-bold text-gray-400 uppercase">Unit Properti</th>
                        <th class="px-6 py-4 text-xs font-bold text-gray-400 uppercase">Total Bayar</th>
                        <th class="px-6 py-4 text-xs font-bold text-gray-400 uppercase">Status</th>
                        <th class="px-6 py-4 text-xs font-bold text-gray-400 uppercase text-center">Aksi</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-gray-100">
                    @forelse($transactions as $trx)
                    <tr>
                        <td class="px-6 py-4">
                            <p class="font-bold text-gray-800">{{ $trx->user->name }}</p>
                            <p class="text-xs text-gray-400">{{ $trx->user->email }}</p>
                        </td>
                        <td class="px-6 py-4 text-sm text-gray-600">{{ $trx->property->name }}</td>
                        <td class="px-6 py-4 font-bold text-gray-800">Rp {{ number_format($trx->amount_paid, 0, ',', '.') }}</td>
                        <td class="px-6 py-4">
                            <span class="px-3 py-1.5 rounded-full text-xs font-bold uppercase {{ $trx->payment_status == 'success' ? 'bg-green-100 text-green-700' : 'bg-yellow-100 text-yellow-700' }}">
                                {{ $trx->payment_status }}
                            </span>
                        </td>
                        <td class="px-6 py-4 text-sm font-medium">
    <a href="{{ route('admin.transaction.show', $trx->id) }}" class="text-blue-600 hover:text-blue-950 font-bold transition duration-150">
        Detail
    </a>
</td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="5" class="px-6 py-10 text-center text-gray-400 italic">Belum ada transaksi di tab ini.</td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</div>
@endsection
