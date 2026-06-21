@extends('layouts.admin')

@section('title', 'Edit Fasilitas')
@section('subtitle', 'Perbarui informasi fasilitas properti.')

@section('content')
<div class="p-6 max-w-2xl">
    <div class="mb-6">
        <a href="{{ route('admin.facilities.index') }}" class="text-blue-600 hover:underline text-sm">&larr; Kembali</a>
        <h1 class="text-2xl font-bold mt-2">Edit Fasilitas</h1>
    </div>

    <div class="bg-white rounded-xl shadow-md p-8">
        <form action="{{ route('admin.facilities.update', $facility->id) }}" method="POST">
            @csrf @method('PUT')

            <div class="mb-6">
                <label for="name" class="block text-sm font-medium text-gray-700 mb-2">Nama Fasilitas *</label>
                <input type="text" id="name" name="name" value="{{ old('name', $facility->name) }}" required
                    class="w-full px-4 py-3 rounded-lg border @error('name') border-red-500 @else border-gray-300 @enderror">
                @error('name') <p class="text-red-500 text-sm mt-1">{{ $message }}</p> @enderror
            </div>

            <div class="mb-6">
                <label for="icon" class="block text-sm font-medium text-gray-700 mb-2">Icon (Class FontAwesome)</label>
                <input type="text" id="icon" name="icon" value="{{ old('icon', $facility->icon) }}"
                    class="w-full px-4 py-3 rounded-lg border @error('icon') border-red-500 @else border-gray-300 @enderror"
                    placeholder="Contoh: fas fa-swimming-pool">
                @error('icon') <p class="text-red-500 text-sm mt-1">{{ $message }}</p> @enderror
            </div>

            <div class="flex justify-end">
                <button type="submit" class="bg-blue-600 text-white px-6 py-3 rounded-lg font-bold hover:bg-blue-700">
                    Update Fasilitas
                </button>
            </div>
        </form>
    </div>
</div>
@endsection
