@extends('layouts.app')

@section('title', 'Jadwal Kunjungan Saya - White House Premiere')

@section('content')
<section class="pt-28 pb-16 bg-gray-50 min-h-screen">
    <div class="max-w-5xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="mb-8">
            <h1 class="font-display text-3xl font-bold text-gray-900">Jadwal Kunjungan Saya</h1>
            <p class="text-gray-500 mt-1">Daftar jadwal survei properti yang telah Anda ajukan.</p>
        </div>

        @if(session('success'))
        <div class="bg-green-50 border border-green-200 text-green-700 px-6 py-4 rounded-xl mb-6 flex items-center">
            <i class="fas fa-check-circle mr-3 text-green-500"></i>
            {{ session('success') }}
        </div>
        @endif

        <div class="bg-white rounded-2xl shadow-sm border border-gray-100 overflow-hidden">
            @if($schedules->isEmpty())
            <div class="py-16 text-center text-gray-400">
                <i class="fas fa-calendar-times text-5xl mb-4 text-gray-300"></i>
                <p class="text-lg font-medium">Belum ada jadwal kunjungan</p>
                <p class="text-sm mt-1">Anda bisa mengajukan jadwal kunjungan dari halaman detail properti.</p>
                <a href="{{ route('project') }}" class="inline-block mt-4 bg-blue-600 text-white px-6 py-2.5 rounded-full font-semibold text-sm hover:bg-blue-700 transition">
                    Lihat Properti
                </a>
            </div>
            @else
            <div class="divide-y divide-gray-100">
                @foreach($schedules as $visit)
                <div class="p-6 flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4">
                    <div class="flex items-start gap-4">
                        <div class="w-14 h-14 bg-blue-50 rounded-xl flex items-center justify-center flex-shrink-0">
                            <i class="fas fa-home text-blue-600 text-xl"></i>
                        </div>
                        <div>
                            <h3 class="font-bold text-gray-900">{{ $visit->property->name ?? 'Properti' }}</h3>
                            <p class="text-sm text-gray-500 mt-0.5">
                                <i class="fas fa-calendar mr-1"></i> {{ \Carbon\Carbon::parse($visit->visit_date)->format('l, d F Y') }}
                                <span class="mx-2">•</span>
                                <i class="fas fa-clock mr-1"></i> {{ \Carbon\Carbon::parse($visit->visit_time)->format('H:i') }} WIB
                            </p>
                            @if($visit->notes)
                            <p class="text-xs text-gray-400 mt-1 italic">"{{ $visit->notes }}"</p>
                            @endif
                        </div>
                    </div>
                    <div class="flex items-center gap-3 flex-shrink-0">
                        @php
                            $statusClass = match($visit->status) {
                                'approved' => 'bg-green-100 text-green-700',
                                'cancelled' => 'bg-red-100 text-red-700',
                                'completed' => 'bg-blue-100 text-blue-700',
                                default => 'bg-yellow-100 text-yellow-700',
                            };
                            $statusLabel = match($visit->status) {
                                'approved' => 'Disetujui',
                                'cancelled' => 'Dibatalkan',
                                'completed' => 'Selesai',
                                default => 'Menunggu',
                            };
                        @endphp
                        <span class="px-3 py-1 rounded-full text-xs font-bold uppercase {{ $statusClass }}">
                            {{ $statusLabel }}
                        </span>
                    </div>
                </div>
                @endforeach
            </div>
            @endif
        </div>
    </div>
</section>
@endsection
