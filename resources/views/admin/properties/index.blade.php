@extends('layouts.admin')

@section('title', 'Daftar Unit Properti')
@section('subtitle', 'Kelola dan pantau semua unit properti.')

@section('content')
<div class="p-6">
    <div class="flex justify-between items-center mb-6">
        <h1 class="text-2xl font-bold">Daftar Unit Properti</h1>
        <a href="{{ route('admin.properties.create') }}" class="bg-blue-600 text-white px-4 py-2 rounded-lg font-bold">
            + Tambah Unit
        </a>
    </div>

    <div class="bg-white rounded-xl shadow-md overflow-hidden">
        <table class="w-full text-left border-collapse">
            <thead class="bg-slate-50 border-b">
                <tr>
                    <th class="p-4 font-semibold text-slate-700">Nama Unit</th>
                    <th class="p-4 font-semibold text-slate-700">Lokasi</th>
                    <th class="p-4 font-semibold text-slate-700">Harga</th>
                    <th class="p-4 font-semibold text-slate-700">Aksi</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-gray-100">
                @forelse($properties as $property)
                <tr class="hover:bg-gray-50/50 transition-colors">
                    <td class="p-4">
                        <div class="flex items-center">
                            <div class="w-16 h-12 bg-gray-100 rounded-lg mr-3 overflow-hidden border border-gray-200 flex items-center justify-center shadow-sm">
                             @if($property->image)
                            <img src="{{ asset('uploads/properties/' . $property->image) }}" alt="Foto Unit" class="w-full h-full object-cover">
                            @else
                            <i class="fas fa-home text-gray-300 text-lg"></i>
                            @endif
                        </div>
                            <div>
                                <div class="text-sm font-bold text-gray-800">{{ $property->name }}</div>
                                <span class="text-xs font-semibold text-blue-600 bg-blue-50 px-2 py-0.5 rounded-full uppercase mt-1 inline-block">
                                    {{ $property->category->name ?? 'Premium' }}
                                </span>
                            </div>
                        </div>
                    </td>

                    <td class="p-4 text-sm text-gray-600 font-medium">
                        @if($property->google_maps_url)
                            <a href="{{ $property->google_maps_url }}" target="_blank" class="text-blue-600 hover:text-blue-800 hover:underline inline-flex items-center" title="Klik untuk lihat di Google Maps">
                                <i class="fas fa-map-marker-alt text-red-500 mr-1.5 animate-bounce"></i>
                                {{ $property->location }} ↗
                            </a>
                        @else
                            <span class="text-gray-400 italic" title="Link Google Maps belum diisi">
                                <i class="fas fa-map-marker-alt text-gray-300 mr-1.5"></i>
                                {{ $property->location }}
                            </span>
                        @endif
                    </td>

                    <td class="p-4 text-sm font-bold text-blue-600">
                        Rp {{ number_format($property->price, 0, ',', '.') }}
                    </td>

                    <td class="p-4">
                        <div class="flex items-center space-x-3">
                            <a href="{{ route('admin.properties.edit', $property->id) }}" class="inline-flex items-center text-yellow-600 hover:text-yellow-800 font-semibold text-sm">
                                <i class="fas fa-edit mr-1"></i> Edit
                            </a>
                            <span class="text-gray-300">|</span>
                            <a href="#" onclick="event.preventDefault(); if(confirm('Yakin hapus?')){ this.nextElementSibling.submit(); }" class="inline-flex items-center text-red-600 hover:text-red-800 font-semibold text-sm">
                                <i class="fas fa-trash mr-1"></i> Hapus
                            </a>
                            <form action="{{ route('admin.properties.destroy', $property->id) }}" method="POST" class="hidden">
                                @csrf @method('DELETE')
                            </form>
                        </div>
                    </td>
                </tr>
                @empty
                <tr>
                    <td colspan="4" class="p-8 text-center text-gray-400 italic">Belum ada properti terdaftar.</td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>
@endsection
