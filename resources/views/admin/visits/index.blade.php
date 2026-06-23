@extends('layouts.admin')

@section('title', 'Jadwal Kunjungan')
@section('subtitle', 'Kelola jadwal kunjungan properti dari pelanggan.')

@section('content')
<div class="p-6">
    <div class="mb-6">
        <h2 class="text-2xl font-bold text-gray-800">Jadwal Kunjungan</h2>
        <p class="text-sm text-gray-500">Daftar calon pembeli yang ingin survei lokasi.</p>
    </div>

    <div class="bg-white rounded-xl shadow-sm border border-gray-100 overflow-hidden">
        <table class="w-full text-left">
            <thead class="bg-gray-50 border-b">
                <tr>
                    <th class="px-6 py-4 text-xs font-bold text-gray-400 uppercase">Nama & Properti</th>
                    <th class="px-6 py-4 text-xs font-bold text-gray-400 uppercase">Waktu Kunjungan</th>
                    <th class="px-6 py-4 text-xs font-bold text-gray-400 uppercase">Status</th>
                    <th class="px-6 py-4 text-xs font-bold text-gray-400 uppercase text-center">Aksi</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-gray-100">
                @foreach($schedules as $visit)
                <tr>
                    <td class="px-6 py-4">
                        <div class="font-bold text-gray-800">{{ $visit->user->name }}</div>
                        <div class="text-xs text-blue-600">{{ $visit->property->name }}</div>
                    </td>
                    <td class="px-6 py-4">
                        <div class="text-sm font-medium">{{ date('d M Y', strtotime($visit->visit_date)) }}</div>
                        <div class="text-xs text-gray-400">{{ date('H:i', strtotime($visit->visit_time)) }} WIB</div>
                    </td>
                    <td class="px-6 py-4">
                        @php
                            $statusColors = [
                                'pending' => 'bg-yellow-100 text-yellow-700',
                                'confirmed' => 'bg-blue-100 text-blue-700',
                                'completed' => 'bg-green-100 text-green-700',
                                'cancelled' => 'bg-red-100 text-red-700',
                            ];
                            $statusLabels = [
                                'pending' => 'Menunggu',
                                'confirmed' => 'Dikonfirmasi',
                                'completed' => 'Selesai',
                                'cancelled' => 'Dibatalkan',
                            ];
                        @endphp
                        <span class="px-3 py-1 rounded-full text-xs font-bold uppercase {{ $statusColors[$visit->status] ?? 'bg-gray-100 text-gray-700' }}">
                            {{ $statusLabels[$visit->status] ?? $visit->status }}
                        </span>
                    </td>
                    <td class="px-6 py-4 text-center">
                        <form action="{{ route('admin.visit-schedules.update', $visit->id) }}" method="POST" class="flex items-center justify-center gap-2">
                            @csrf @method('PATCH')
                            <select name="status" class="text-xs border-gray-200 rounded-lg focus:ring-blue-500 cursor-pointer">
                                <option value="pending" {{ $visit->status == 'pending' ? 'selected' : '' }}>Menunggu</option>
                                <option value="confirmed" {{ $visit->status == 'confirmed' ? 'selected' : '' }}>Dikonfirmasi</option>
                                <option value="completed" {{ $visit->status == 'completed' ? 'selected' : '' }}>Selesai</option>
                                <option value="cancelled" {{ $visit->status == 'cancelled' ? 'selected' : '' }}>Dibatalkan</option>
                            </select>
                            <button type="submit" class="text-xs px-3 py-1.5 bg-blue-600 text-white rounded-lg hover:bg-blue-700">Update</button>
                        </form>
                    </td>
                </tr>
                @endforeach
            </tbody>
        </table>
    </div>
</div>
@endsection
