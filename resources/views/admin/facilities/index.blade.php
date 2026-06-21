@extends('layouts.admin')

@section('title', 'Fasilitas')
@section('subtitle', 'Kelola daftar fasilitas properti.')

@section('content')
<div class="p-6">
    <div class="flex justify-between items-center mb-6">
        <h1 class="text-2xl font-bold">Daftar Fasilitas</h1>
        <a href="{{ route('admin.facilities.create') }}" class="bg-blue-600 text-white px-4 py-2 rounded-lg font-bold">
            + Tambah Fasilitas
        </a>
    </div>

    @if(session('success'))
        <div class="mb-4 p-4 bg-green-100 text-green-700 rounded-lg">{{ session('success') }}</div>
    @endif

    <div class="bg-white rounded-xl shadow-md overflow-hidden">
        <table class="w-full text-left border-collapse">
            <thead class="bg-slate-50 border-b">
                <tr>
                    <th class="p-4 font-semibold text-slate-700">Icon</th>
                    <th class="p-4 font-semibold text-slate-700">Nama Fasilitas</th>
                    <th class="p-4 font-semibold text-slate-700">Aksi</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-gray-100">
                @forelse($facilities as $facility)
                <tr class="hover:bg-gray-50/50 transition-colors">
                    <td class="p-4">
                        @if($facility->icon)
                            <i class="{{ $facility->icon }} text-blue-600 text-xl"></i>
                        @else
                            <i class="fas fa-check-circle text-gray-300 text-xl"></i>
                        @endif
                    </td>
                    <td class="p-4 text-sm font-bold text-gray-800">{{ $facility->name }}</td>
                    <td class="p-4">
                        <div class="flex items-center space-x-3">
                            <a href="{{ route('admin.facilities.edit', $facility->id) }}" class="inline-flex items-center text-yellow-600 hover:text-yellow-800 font-semibold text-sm">
                                <i class="fas fa-edit mr-1"></i> Edit
                            </a>
                            <span class="text-gray-300">|</span>
                            <a href="#" onclick="event.preventDefault(); if(confirm('Yakin hapus?')){ this.nextElementSibling.submit(); }" class="inline-flex items-center text-red-600 hover:text-red-800 font-semibold text-sm">
                                <i class="fas fa-trash mr-1"></i> Hapus
                            </a>
                            <form action="{{ route('admin.facilities.destroy', $facility->id) }}" method="POST" class="hidden">
                                @csrf @method('DELETE')
                            </form>
                        </div>
                    </td>
                </tr>
                @empty
                <tr>
                    <td colspan="3" class="p-8 text-center text-gray-400 italic">Belum ada fasilitas terdaftar.</td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>
@endsection
