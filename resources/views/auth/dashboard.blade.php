@extends('layouts.app')

@section('content')
<div class="bg-gray-100 min-h-screen pt-24 pb-12">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">

        @if(request()->get('payment') == 'success' || session('success'))
            <div class="alert alert-success alert-dismissible fade show animate-fade-in" role="alert" style="border-left: 5px solid #2f855a; background-color: #f0fff4; color: #22543d; padding: 20px; margin-bottom: 25px; border-radius: 8px; font-family: sans-serif; shadow: 0 1px 3px 0 rgba(0, 0, 0, 0.1);">
                <h5 style="margin-top: 0; font-weight: bold; font-size: 16px; display: flex; align-items: center;">
                    <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24" style="width: 20px; height: 20px;"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                    🎉 Pembayaran Berhasil!
                </h5>
                <p style="margin-bottom: 0; font-size: 14px; opacity: 0.9;">Terima kasih, pembayaran untuk properti Anda telah kami terima. Silakan unduh dokumen invoice resmi Anda pada tabel di bawah ini.</p>
            </div>
        @endif

        <div class="bg-white rounded-2xl shadow-sm border border-gray-200 p-6 mb-8 mt-4">
            <div class="flex items-center space-x-4">
                <div class="h-14 w-14 rounded-full bg-blue-600 flex items-center justify-center text-white text-xl font-bold uppercase shadow-inner">
                    {{ substr($user->name, 0, 2) }}
                </div>
                <div>
                    <h1 class="text-2xl font-bold text-gray-900">Selamat Datang, {{ $user->name }}!</h1>
                    <p class="text-sm text-gray-500">{{ $user->email }} • Akun Pembeli</p>
                </div>
                <a href="{{ route('chat.index') }}" class="ml-auto flex items-center gap-2 px-4 py-2 bg-blue-50 text-blue-600 rounded-xl hover:bg-blue-100 transition border border-blue-200">
                    <i class="fas fa-comments"></i>
                    <span class="text-sm font-semibold">Percakapan Saya</span>
                </a>
            </div>
        </div>

        <div class="grid grid-cols-1 md:grid-cols-3 gap-6 mb-8">
            <div class="bg-white p-6 rounded-2xl shadow-sm border border-gray-200 flex items-center justify-between">
                <div>
                    <p class="text-xs font-semibold text-gray-400 uppercase tracking-wider">Inquiry Aktif</p>
                    <h3 class="text-3xl font-bold text-gray-900 mt-1">{{ $activeInquiries }}</h3>
                </div>
                <div class="p-3 rounded-xl bg-yellow-50 text-yellow-600">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"></path></svg>
                </div>
            </div>

            <div class="bg-white p-6 rounded-2xl shadow-sm border border-gray-200 flex items-center justify-between">
                <div>
                    <p class="text-xs font-semibold text-gray-400 uppercase tracking-wider">Booking Aktif</p>
                    <h3 class="text-3xl font-bold text-gray-900 mt-1">{{ $activeBookings }}</h3>
                </div>
                <div class="p-3 rounded-xl bg-green-50 text-green-600">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                </div>
            </div>

            <div class="bg-white p-6 rounded-2xl shadow-sm border border-gray-200 flex items-center justify-between">
                <div>
                    <p class="text-xs font-semibold text-gray-400 uppercase tracking-wider">Total Transaksi</p>
                    <h3 class="text-3xl font-bold text-gray-900 mt-1">{{ $totalTransactions }}</h3>
                </div>
                <div class="p-3 rounded-xl bg-purple-50 text-purple-600">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2"></path></svg>
                </div>
            </div>
        </div>

        <div class="grid grid-cols-1 lg:grid-cols-2 gap-8 mb-8">
            <div class="bg-white rounded-2xl shadow-sm border border-gray-200 p-6 flex flex-col justify-between">
                <div>
                    <h2 class="text-lg font-bold text-gray-900 mb-4 flex items-center">
                        <svg class="w-5 h-5 mr-2 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"></path></svg>
                        Jadwal Kunjungan Terjadwal
                    </h2>

                    @if($visitSchedules->isEmpty())
                        <div class="py-8 text-center text-gray-400">
                            <p class="text-sm font-medium">Belum ada kunjungan lapangan yang dijadwalkan.</p>
                        </div>
                    @else
                        <div class="space-y-3">
                            @foreach($visitSchedules as $visit)
                            <div class="p-4 bg-gray-50 rounded-xl border border-gray-100 flex justify-between items-center">
                                <div>
                                    <h4 class="font-bold text-gray-800 text-sm">{{ $visit->property->name ?? 'Luxury Unit' }}</h4>
                                    <p class="text-xs text-gray-400 mt-0.5">{{ \Carbon\Carbon::parse($visit->visit_date)->format('d M Y') }} • {{ $visit->visit_time }}</p>
                                </div>
                                <span class="px-2.5 py-1 text-xs font-semibold rounded-full bg-blue-100 text-blue-800 uppercase">
                                    {{ $visit->status ?? 'Terjadwal' }}
                                </span>
                            </div>
                            @endforeach
                        </div>
                    @endif
                </div>
            </div>

            <div class="bg-white rounded-2xl shadow-sm border border-gray-200 p-6 flex flex-col justify-between">
                <div>
                    <h2 class="text-lg font-bold text-gray-900 mb-4 flex items-center">
                        <svg class="w-5 h-5 mr-2 text-red-500" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4.318 6.318a4.5 4.5 0 000 6.364L12 20.364l7.682-7.682a4.5 4.5 0 00-6.364-6.364L12 7.636l-1.318-1.318a4.5 4.5 0 00-6.364 0z"></path></svg>
                        Favorit Properti Saya
                    </h2>

                    @if(isset($savedProperties) && $savedProperties->count() > 0)
                        <div class="space-y-3">
                            @foreach($savedProperties as $sp)
                            <a href="{{ route('project.show', $sp->id) }}" class="block p-4 bg-gray-50 rounded-xl border border-gray-100 hover:bg-gray-100 transition-colors">
                                <div class="flex items-center space-x-3">
                                    <div class="w-16 h-16 rounded-lg overflow-hidden bg-gray-200 shrink-0">
                                        <img src="{{ asset('uploads/properties/' . ($sp->image ?? 'placeholder.jpg')) }}" alt="{{ $sp->name }}" class="w-full h-full object-cover">
                                    </div>
                                    <div class="flex-1 min-w-0">
                                        <h4 class="font-bold text-gray-800 text-sm truncate">{{ $sp->name }}</h4>
                                        <p class="text-xs text-gray-400 mt-0.5">Rp {{ number_format($sp->price, 0, ',', '.') }}</p>
                                    </div>
                                    <i class="fas fa-chevron-right text-gray-300 text-xs"></i>
                                </div>
                            </a>
                            @endforeach
                            <a href="{{ route('saved.properties') }}" class="block text-center text-blue-600 text-sm font-semibold pt-2 hover:underline">
                                Lihat Semua Favorit
                            </a>
                        </div>
                    @else
                        <div class="py-8 text-center text-gray-400">
                            <p class="text-sm font-medium">Belum ada properti yang kamu simpan.</p>
                            <a href="{{ route('project') }}" class="text-blue-600 text-sm font-semibold mt-2 inline-block hover:underline">Jelajahi Properti</a>
                        </div>
                    @endif
                </div>
            </div>
        </div>

        <div class="bg-white rounded-2xl shadow-sm border border-gray-200 overflow-hidden">
            <div class="p-6 border-b border-gray-200">
                <h2 class="text-lg font-bold text-gray-900" style="font-weight: bold; color: #1a202c;">Riwayat Transaksi Pembayaran</h2>
            </div>

            @if($transactions->count() > 0)
                <div class="overflow-x-auto" style="padding: 10px;">
                    <table class="w-full text-left border-collapse" style="vertical-align: middle;">
                        <thead>
                            <tr class="bg-gray-50 text-xs font-semibold text-gray-500 uppercase tracking-wider border-b border-gray-200">
                                <th class="p-4">Kode Transaksi</th>
                                <th class="p-4">Nama Properti</th>
                                <th class="p-4">Total Pembayaran</th>
                                <th class="p-4">Status</th>
                                <th class="p-4 text-center">Aksi / Dokumen</th>
                            </tr>
                        </thead>
                        <tbody class="text-sm divide-y divide-gray-200 text-gray-700">
                            @foreach($transactions as $item)
                                <tr class="hover:bg-gray-50 transition-colors">
                                    <td class="p-4 font-mono font-bold text-blue-600" style="font-family: monospace; font-weight: bold;">
                                        {{ $item->transaction_code }}
                                    </td>
                                    <td class="p-4">
                                        {{ $item->property->name ?? 'White House Premier 2' }}
                                    </td>
                                    <td class="p-4 font-semibold text-gray-900" style="font-weight: bold; color: #2b6cb0;">
                                        Rp {{ number_format($item->gross_amount, 0, ',', '.') }}
                                    </td>
                                    <td class="p-4">
                                        @if($item->payment_status == 'success')
                                            <span class="px-2.5 py-1 text-xs font-bold rounded-full bg-green-100 text-green-800 uppercase tracking-wider" style="padding: 6px 12px; border-radius: 5px;">
                                                SUCCESS
                                            </span>
                                        @elseif($item->payment_status == 'booking_paid')
                                            <span class="px-2.5 py-1 text-xs font-bold rounded-full bg-blue-100 text-blue-800 uppercase tracking-wider" style="padding: 6px 12px; border-radius: 5px;">
                                                BOOKING PAID
                                            </span>
                                        @elseif($item->payment_status == 'pending')
                                            <span class="px-2.5 py-1 text-xs font-bold rounded-full bg-yellow-100 text-yellow-800 uppercase tracking-wider" style="padding: 6px 12px; border-radius: 5px;">
                                                PENDING
                                            </span>
                                        @else
                                            <span class="px-2.5 py-1 text-xs font-bold rounded-full bg-red-100 text-red-800 uppercase tracking-wider" style="padding: 6px 12px; border-radius: 5px;">
                                                CANCELLED
                                            </span>
                                        @endif

                                        @if(($item->is_installment ?? false) && ($item->installment_count ?? 0) > 0)
                                        <div class="mt-2">
                                            <div class="flex items-center gap-1 text-xs">
                                                <span class="text-purple-600 font-semibold">Cicilan:</span>
                                                <span>{{ $item->paid_installments }}/{{ $item->installment_count }}</span>
                                            </div>
                                            <div class="w-full bg-gray-200 rounded-full h-1.5 mt-1">
                                                @php $prog = min(100, ($item->paid_installments / $item->installment_count) * 100); @endphp
                                                <div class="bg-purple-500 h-1.5 rounded-full" style="width: {{ $prog }}%"></div>
                                            </div>
                                        </div>
                                        @endif
                                    </td>
                                    <td class="p-4 text-center">
                                        @if($item->payment_status == 'booking_paid')
                                            <a href="{{ route('transaction.pelunasan', $item->id) }}" class="inline-flex items-center px-3 py-1.5 bg-blue-600 text-white rounded-lg text-xs font-bold hover:bg-blue-700 transition">
                                                <svg class="w-3.5 h-3.5 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 7l5 5m0 0l-5 5m5-5H6"/>
                                                </svg>
                                                Lanjutkan Pelunasan
                                            </a>
                                        @elseif(($item->is_installment ?? false) && ($item->paid_installments ?? 0) < ($item->installment_count ?? 1))
                                            @php $nextInst = $item->nextDueInstallment; @endphp
                                            @if($nextInst && $nextInst->payment_status === 'pending')
                                            <a href="{{ route('installment.pay', $nextInst->id) }}" class="text-purple-600 hover:underline font-semibold text-xs">
                                                Bayar Cicilan #{{ $nextInst->installment_number }}
                                            </a>
                                            @endif
                                        @elseif($item->payment_status == 'success')
                                            <a href="{{ route('transaction.download', $item->id) }}" class="text-blue-600 hover:underline">
                                             Download Invoice
                                            </a>
                                        @else
                                            <span class="text-xs text-gray-400 italic" style="font-size: 13px; font-style: italic; color: #a0aec0;">Invoice belum tersedia</span>
                                        @endif
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            @else
                <div class="p-12 text-center">
                    <div class="w-16 h-16 bg-gray-100 rounded-full flex items-center justify-center mx-auto mb-4">
                        <svg class="w-8 h-8 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2"></path></svg>
                    </div>
                    <p class="text-gray-500 font-medium text-base">Belum ada transaksi</p>
                    <p class="text-gray-400 text-sm mt-1">Semua riwayat pembayaran properti Anda akan muncul di sini.</p>
                </div>
            @endif
        </div>

    </div>
</div>
@endsection
