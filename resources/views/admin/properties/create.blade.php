@extends('layouts.admin')

@section('title', 'Tambah Unit Properti')
@section('subtitle', 'Tambahkan unit properti baru ke dalam sistem.')

@section('content')
<div class="p-6">
    <div class="flex items-center justify-between mb-6">
        <h1 class="text-2xl font-bold text-slate-800">Tambah Unit Properti Baru</h1>
        <a href="{{ route('admin.properties.index') }}" class="text-slate-500 hover:text-slate-700">← Kembali</a>
    </div>

    @if ($errors->any())
        <div class="mb-6 p-4 bg-red-100 border-l-4 border-red-500 text-red-700 shadow-sm">
            <p class="font-bold">Gagal menyimpan! Periksa kembali:</p>
            <ul class="mt-2 list-disc list-inside text-sm">
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <div class="bg-white rounded-xl shadow-sm border border-slate-200 p-6">
        <form action="{{ route('admin.properties.store') }}" method="POST" enctype="multipart/form-data">
            @csrf

            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                <div class="space-y-2">
                    <label class="text-sm font-semibold text-slate-700">Nama Properti</label>
                    <input type="text" name="name" value="{{ old('name') }}" class="w-full px-4 py-2 border border-slate-300 rounded-lg focus:ring-2 focus:ring-blue-400 outline-none" placeholder="Contoh: Unit Kavling A1" required>
                </div>

                <div class="space-y-2">
                    <label class="text-sm font-semibold text-slate-700">Lokasi</label>
                    <input type="text" name="location" value="{{ old('location') }}" class="w-full px-4 py-2 border border-slate-300 rounded-lg focus:ring-2 focus:ring-blue-400 outline-none" placeholder="Contoh: Menteng, Jakarta Pusat" required>
                </div>

                <div class="mb-4">
                    <label for="google_maps_url" class="block text-sm font-semibold text-gray-700 mb-2">Link Google Maps (URL)</label>
                    <input type="url" name="google_maps_url" id="google_maps_url"
                    class="w-full px-4 py-2 border border-gray-200 rounded-xl focus:outline-none focus:border-blue-500 text-sm"
                    placeholder="Contoh: https://maps.app.goo.gl/xxxxxx" value="{{ old('google_maps_url') }}">
                    <p class="text-xs text-gray-400 mt-1">*Buka Google Maps, cari lokasi, klik 'Bagikan' atau 'Share', lalu salin link-nya ke sini.</p>
                </div>

                <div class="space-y-2">
                    <label class="text-sm font-semibold text-slate-700">Harga (Rp)</label>
                    <input type="number" name="price" value="{{ old('price') }}" class="w-full px-4 py-2 border border-slate-300 rounded-lg focus:ring-2 focus:ring-blue-400 outline-none" placeholder="Contoh: 550000000" required>
                </div>

                <div class="space-y-2">
                    <label class="text-sm font-semibold text-slate-700">Status Penjualan</label>
                    <select name="status" class="w-full px-4 py-2 border border-slate-300 rounded-lg outline-none focus:ring-2 focus:ring-blue-400">
                        <option value="available" {{ old('status') == 'available' ? 'selected' : '' }}>Tersedia (Available)</option>
                        <option value="sold" {{ old('status') == 'sold' ? 'selected' : '' }}>Terjual (Sold)</option>
                        <option value="booked" {{ old('status') == 'booked' ? 'selected' : '' }}>Terpesan (Booked)</option>
                    </select>
                </div>

                <div class="space-y-2">
                    <label class="text-sm font-semibold text-slate-700">Cluster Induk</label>
                    <select name="category_id" class="w-full px-4 py-2 border border-slate-300 rounded-lg outline-none focus:ring-2 focus:ring-blue-400" required>
                        <option value="">-- Pilih Cluster --</option>
                        @foreach($categories as $category)
                            <option value="{{ $category->id }}" {{ old('category_id') == $category->id ? 'selected' : '' }}>{{ $category->name }}</option>
                        @endforeach
                    </select>
                </div>

                <div class="space-y-2">
                    <label class="text-sm font-semibold text-slate-700">Tipe Bangunan</label>
                    <select name="type_id" class="w-full px-4 py-2 border border-slate-300 rounded-lg outline-none focus:ring-2 focus:ring-blue-400" required>
                        <option value="">-- Pilih Tipe --</option>
                        @foreach($types as $type)
                            <option value="{{ $type->id }}" {{ old('type_id') == $type->id ? 'selected' : '' }}>{{ $type->name }}</option>
                        @endforeach
                    </select>
                </div>

                <div class="grid grid-cols-2 gap-4">
                    <div class="space-y-2">
                        <label class="text-sm font-semibold text-slate-700">Kamar Tidur</label>
                        <input type="number" name="bedrooms" value="{{ old('bedrooms', 0) }}" class="w-full px-4 py-2 border border-slate-300 rounded-lg outline-none">
                    </div>
                    <div class="space-y-2">
                        <label class="text-sm font-semibold text-slate-700">Kamar Mandi</label>
                        <input type="number" name="bathrooms" value="{{ old('bathrooms', 0) }}" class="w-full px-4 py-2 border border-slate-300 rounded-lg outline-none">
                    </div>
                </div>
                <div class="grid grid-cols-2 gap-4">
                    <div class="space-y-2">
                        <label class="text-sm font-semibold text-slate-700">Luas Bangunan (m²)</label>
                        <input type="number" name="building_area" value="{{ old('building_area', 0) }}" class="w-full px-4 py-2 border border-slate-300 rounded-lg outline-none">
                    </div>
                    <div class="space-y-2">
                        <label class="text-sm font-semibold text-slate-700">Luas Tanah (m²)</label>
                        <input type="number" name="land_area" value="{{ old('land_area', 0) }}" class="w-full px-4 py-2 border border-slate-300 rounded-lg outline-none">
                    </div>
                </div>
            </div>

            <div class="mt-6 space-y-2">
                <label class="text-sm font-semibold text-slate-700">Deskripsi <span class="text-red-500">*</span></label>
                <textarea name="description" rows="4" class="w-full px-4 py-2 border border-slate-300 rounded-lg outline-none focus:ring-2 focus:ring-blue-400 @error('description') border-red-500 @enderror" placeholder="Tuliskan detail unit di sini...">{{ old('description') }}</textarea>
                @error('description')
                    <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                @enderror
            </div>

            <div class="mt-8">
    <h3 class="text-lg font-bold text-slate-800 mb-4 border-b pb-2">Gallery Foto Unit</h3>
    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
        <div class="space-y-2">
            <label class="text-sm font-semibold text-slate-700">Foto Utama (Thumbnail) <span class="text-red-500">*</span></label>
            <input type="file" name="image" class="w-full px-4 py-2 border border-slate-300 rounded-lg outline-none bg-white" required>
        </div>

        <div class="space-y-2">
            <label class="text-sm font-semibold text-slate-700">Foto Kamar Tidur</label>
            <input type="file" name="image_living_room" class="w-full px-4 py-2 border border-slate-300 rounded-lg outline-none bg-white">
        </div>

        <div class="space-y-2">
            <label class="text-sm font-semibold text-slate-700">Foto Kamar Mandi</label>
            <input type="file" name="image_bathroom" class="w-full px-4 py-2 border border-slate-300 rounded-lg outline-none bg-white">
        </div>

        <div class="space-y-2">
            <label class="text-sm font-semibold text-slate-700">Foto Eksterior / Luar</label>
            <input type="file" name="image_exterior" class="w-full px-4 py-2 border border-slate-300 rounded-lg outline-none bg-white">
        </div>
    </div>
</div>

            <button type="submit" class="mt-8 w-full bg-blue-600 text-white font-bold py-3 rounded-lg hover:bg-blue-700 transition shadow-lg shadow-blue-200">
                Simpan Unit Properti
            </button>
        </form>
    </div>
</div>
@endsection
