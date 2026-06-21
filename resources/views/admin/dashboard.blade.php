@extends('layouts.admin')

@section('title', 'Dashboard')
@section('subtitle', 'Ringkasan statistik dan aktivitas properti Anda hari ini.')

@section('content')
<div class="p-6">
    <div class="mb-8">
        <h1 class="text-2xl font-bold text-gray-800">Ringkasan Statistik</h1>
        <p class="text-gray-500">Selamat datang kembali, Admin. Berikut adalah ikhtisar properti Anda hari ini.</p>
    </div>

    <div class="grid grid-cols-1 md:grid-cols-4 gap-6 mb-8">
        <div class="bg-white p-6 rounded-2xl shadow-sm border border-gray-100 flex items-center">
            <div class="p-3 rounded-xl bg-yellow-50 text-yellow-600 mr-4">
                <i class="fas fa-money-bill-wave text-2xl"></i>
            </div>
            <div>
                <p class="text-sm font-medium text-gray-400">Total Pendapatan</p>
                <p class="text-xl font-bold text-gray-800">Rp {{ number_format($totalRevenue ?? 0, 0, ',', '.') }}</p>
            </div>
        </div>

        <div class="bg-white p-6 rounded-2xl shadow-sm border border-gray-100 flex items-center">
            <div class="p-3 rounded-xl bg-blue-50 text-blue-600 mr-4">
                <i class="fas fa-building text-2xl"></i>
            </div>
            <div>
                <p class="text-sm font-medium text-gray-400">Total Properti</p>
                <p class="text-2xl font-bold text-gray-800">{{ $totalProperties ?? 0 }}</p>
            </div>
        </div>

        <div class="bg-white p-6 rounded-2xl shadow-sm border border-gray-100 flex items-center">
            <div class="p-3 rounded-xl bg-green-50 text-green-600 mr-4">
                <i class="fas fa-check-circle text-2xl"></i>
            </div>
            <div>
                <p class="text-sm font-medium text-gray-400">Unit Terjual</p>
                <p class="text-2xl font-bold text-gray-800">{{ $unitsSold ?? 0 }}</p>
            </div>
        </div>

        <div class="bg-white p-6 rounded-2xl shadow-sm border border-gray-100 flex items-center {{ $pendingVisitCount > 0 ? 'ring-2 ring-red-200' : '' }}">
            <div class="p-3 rounded-xl bg-red-50 text-red-600 mr-4">
                <i class="fas fa-calendar-check text-2xl"></i>
            </div>
            <div>
                <p class="text-sm font-medium text-gray-400">Kunjungan Baru</p>
                <p class="text-2xl font-bold {{ $pendingVisitCount > 0 ? 'text-red-600' : 'text-gray-800' }}">
                    {{ $pendingVisitCount ?? 0 }}
                    @if($pendingVisitCount > 0)
                    <span class="text-xs font-normal text-red-500 ml-1">menunggu</span>
                    @endif
                </p>
            </div>
        </div>
    </div>

    <div class="grid grid-cols-1 lg:grid-cols-3 gap-8 mb-8">
        <div class="lg:col-span-2 bg-white p-6 rounded-2xl shadow-sm border border-gray-100">
            <h2 class="font-bold text-gray-800 text-lg mb-4">Tren Pendapatan (6 Bulan Terakhir)</h2>
            <div class="relative h-[300px]">
                <canvas id="salesChart"></canvas>
            </div>
        </div>

        <div class="bg-white p-6 rounded-2xl shadow-sm border border-gray-100 flex flex-col justify-between">
            <h2 class="font-bold text-gray-800 text-lg mb-4">Status Unit Properti</h2>
            <div class="relative h-[250px] flex justify-center items-center">
                <canvas id="statusChart"></canvas>
            </div>
        </div>
    </div>

    <div class="grid grid-cols-1 lg:grid-cols-2 gap-8">
        <div class="bg-white rounded-2xl shadow-sm border border-gray-100 overflow-hidden">
            <div class="p-6 border-b border-gray-100 flex justify-between items-center">
                <h2 class="font-bold text-gray-800 text-lg">Unit Terbaru</h2>
                <a href="{{ route('admin.properties.index') }}" class="text-blue-600 text-sm font-semibold hover:underline">Lihat Semua</a>
            </div>
            <div class="overflow-x-auto">
                <table class="w-full text-left">
                    <thead class="bg-gray-50">
                        <tr>
                            <th class="p-4 text-xs font-semibold text-gray-500 uppercase">Unit</th>
                            <th class="p-4 text-xs font-semibold text-gray-500 uppercase">Lokasi</th>
                            <th class="p-4 text-xs font-semibold text-gray-500 uppercase">Harga</th>
                            <th class="p-4 text-xs font-semibold text-gray-500 uppercase">Aksi</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-gray-100">
                        @forelse($recentProperties ?? [] as $recent)
                        <tr>
                            <td class="p-4 text-sm font-medium text-gray-800">{{ $recent->name }}</td>
                            <td class="p-4 text-sm text-gray-500">{{ $recent->location }}</td>
                            <td class="p-4 text-sm font-semibold text-blue-600">Rp {{ number_format($recent->price, 0, ',', '.') }}</td>
                            <td class="p-4">
                                <a href="{{ route('admin.properties.edit', $recent->id) }}" class="text-gray-400 hover:text-blue-600">
                                    <i class="fas fa-edit"></i>
                                </a>
                            </td>
                        </tr>
                        @empty
                        <tr>
                            <td colspan="4" class="p-8 text-center text-gray-400 italic">Belum ada unit terbaru.</td>
                        </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>

        <div class="bg-white rounded-2xl shadow-sm border border-gray-100 overflow-hidden">
            <div class="p-6 border-b border-gray-100 flex justify-between items-center">
                <h2 class="font-bold text-gray-800 text-lg">
                    <i class="fas fa-calendar-check text-green-500 mr-2"></i>
                    Kunjungan Menunggu
                    @if($pendingVisitCount > 0)
                    <span class="bg-red-500 text-white text-xs font-bold px-2 py-0.5 rounded-full ml-2">{{ $pendingVisitCount }}</span>
                    @endif
                </h2>
                <a href="{{ route('admin.visit-schedules.index') }}" class="text-blue-600 text-sm font-semibold hover:underline">Kelola</a>
            </div>
            <div class="divide-y divide-gray-100">
                @forelse($pendingVisits ?? [] as $visit)
                <div class="p-4 flex items-center justify-between">
                    <div>
                        <p class="text-sm font-semibold text-gray-800">{{ $visit->user->name ?? 'User' }}</p>
                        <p class="text-xs text-gray-500 mt-0.5">{{ $visit->property->name ?? 'Properti' }} • {{ \Carbon\Carbon::parse($visit->visit_date)->format('d M Y') }}</p>
                    </div>
                    <span class="text-xs bg-yellow-100 text-yellow-700 px-2.5 py-1 rounded-full font-semibold">Menunggu</span>
                </div>
                @empty
                <div class="p-8 text-center text-gray-400 italic text-sm">
                    <i class="fas fa-check-circle text-green-400 text-2xl mb-2 block"></i>
                    Tidak ada kunjungan yang menunggu konfirmasi.
                </div>
                @endforelse
            </div>
        </div>
    </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script>
    document.addEventListener("DOMContentLoaded", function () {
        // 1. Grafik Tren Pendapatan (Line Chart)
        const salesCtx = document.getElementById('salesChart').getContext('2d');
        new Chart(salesCtx, {
            type: 'line',
            data: {
                labels: {!! json_encode($salesData ? $salesData->pluck('month') : ['Jan', 'Feb', 'Mar']) !!},
                datasets: [{
                    label: 'Pendapatan (Rupiah)',
                    data: {!! json_encode($salesData ? $salesData->pluck('total') : [0, 0, 0]) !!},
                    borderColor: '#2563eb',
                    backgroundColor: 'rgba(37, 99, 235, 0.1)',
                    fill: true,
                    tension: 0.4
                }]
            },
            options: {
                responsive: true,
                maintainAspectRatio: false
            }
        });

        // 2. Grafik Status Unit (Doughnut Chart)
        const statusCtx = document.getElementById('statusChart').getContext('2d');
        new Chart(statusCtx, {
            type: 'doughnut',
            data: {
                labels: ['Tersedia', 'Terjual', 'Dipesan'],
                datasets: [{
                    data: [
                        {{ $statusCounts['available'] ?? 0 }},
                        {{ $statusCounts['sold'] ?? 0 }},
                        {{ $statusCounts['booked'] ?? 0 }}
                    ],
                    backgroundColor: ['#10b981', '#ef4444', '#f59e0b']
                }]
            },
            options: {
                responsive: true,
                maintainAspectRatio: false
            }
        });
    });
</script>
@endsection
