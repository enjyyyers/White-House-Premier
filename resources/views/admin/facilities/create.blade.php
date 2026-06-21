@extends('layouts.admin')

@section('title', 'Tambah Fasilitas')
@section('subtitle', 'Tambahkan fasilitas properti baru.')

@section('content')
<div class="p-6 max-w-2xl">
    <div class="mb-6">
        <a href="{{ route('admin.facilities.index') }}" class="text-blue-600 hover:underline text-sm">&larr; Kembali</a>
        <h1 class="text-2xl font-bold mt-2">Tambah Fasilitas Baru</h1>
    </div>

    <div class="bg-white rounded-xl shadow-md p-8">
        <form action="{{ route('admin.facilities.store') }}" method="POST">
            @csrf

            <div class="mb-6">
                <label for="name" class="block text-sm font-medium text-gray-700 mb-2">Nama Fasilitas *</label>
                <input type="text" id="name" name="name" value="{{ old('name') }}" required
                    class="w-full px-4 py-3 rounded-lg border @error('name') border-red-500 @else border-gray-300 @enderror"
                    placeholder="Contoh: Kolam Renang">
                @error('name') <p class="text-red-500 text-sm mt-1">{{ $message }}</p> @enderror
            </div>

            <div class="mb-6">
                <label for="icon" class="block text-sm font-medium text-gray-700 mb-2">Icon (Class FontAwesome)</label>
                <input type="text" id="icon" name="icon" value="{{ old('icon') }}"
                    class="w-full px-4 py-3 rounded-lg border @error('icon') border-red-500 @else border-gray-300 @enderror"
                    placeholder="Contoh: fas fa-swimming-pool">
                <p class="text-xs text-gray-400 mt-1">Gunakan class FontAwesome. Cari icon di <a href="https://fontawesome.com/icons" target="_blank" class="text-blue-600">fontawesome.com/icons</a></p>
                @error('icon') <p class="text-red-500 text-sm mt-1">{{ $message }}</p> @enderror
            </div>

            <div class="flex justify-end">
                <button type="submit" class="bg-blue-600 text-white px-6 py-3 rounded-lg font-bold hover:bg-blue-700">
                    Simpan Fasilitas
                </button>
            </div>
        </form>
    </div>
</div>
@endsection
