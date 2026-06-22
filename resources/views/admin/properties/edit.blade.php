@extends('layouts.admin')

@section('title', 'Edit Unit Properti')
@section('subtitle', 'Perbarui informasi unit properti yang sudah ada.')

@section('content')
<div class="p-6">
    <div class="flex items-center justify-between mb-6">
        <h1 class="text-2xl font-bold text-slate-800">Edit Unit Properti</h1>
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
        <form action="{{ route('admin.properties.update', $property->id) }}" method="POST" enctype="multipart/form-data">
            @csrf
            @method('PUT')

            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                <div class="space-y-2">
                    <label class="text-sm font-semibold text-slate-700">Nama Properti</label>
                    <input type="text" name="name" value="{{ old('name', $property->name) }}" class="w-full px-4 py-2 border border-slate-300 rounded-lg focus:ring-2 focus:ring-blue-400 outline-none @error('name') border-red-500 @enderror" placeholder="Contoh: Unit Kavling A1" required>
                    @error('name')
                        <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                    @enderror
                </div>

               <div class="space-y-2">
                     <label class="text-sm font-semibold text-slate-700">Lokasi</label>
                     <input type="text" name="location" value="{{ old('location', $property->location) }}" placeholder="Contoh: Menteng, Jakarta Pusat" class="w-full px-4 py-2 border border-slate-300 rounded-lg outline-none bg-white" required>
                 </div>

                 <div class="space-y-2">
                     <label class="text-sm font-semibold text-slate-700">Link Google Maps (URL)</label>
                     <input type="url" name="google_maps_url" value="{{ old('google_maps_url', $property->google_maps_url) }}" placeholder="https://maps.app.goo.gl/..." class="w-full px-4 py-2 border border-slate-300 rounded-lg outline-none bg-white">
                     <p class="text-[11px] text-slate-400">*Buka Google Maps, cari lokasi, klik 'Bagikan' atau 'Share', lalu salin link-nya ke sini.</p>
                 </div>

                <div class="space-y-2">
                    <label class="text-sm font-semibold text-slate-700">Harga (Rp)</label>
                    <input type="number" name="price" value="{{ old('price', $property->price) }}" class="w-full px-4 py-2 border border-slate-300 rounded-lg focus:ring-2 focus:ring-blue-400 outline-none" placeholder="Contoh: 550000000" required>
                </div>

                <div class="space-y-2">
                    <label class="text-sm font-semibold text-slate-700">Status Penjualan</label>
                    <select name="status" class="w-full px-4 py-2 border border-slate-300 rounded-lg outline-none focus:ring-2 focus:ring-blue-400">
                        <option value="available" {{ old('status', $property->status) == 'available' ? 'selected' : '' }}>Tersedia (Available)</option>
                        <option value="sold" {{ old('status', $property->status) == 'sold' ? 'selected' : '' }}>Terjual (Sold)</option>
                        <option value="booked" {{ old('status', $property->status) == 'booked' ? 'selected' : '' }}>Terpesan (Booked)</option>
                    </select>
                </div>

                <div class="space-y-2">
                    <label class="text-sm font-semibold text-slate-700">Cluster Induk</label>
                    <select name="category_id" class="w-full px-4 py-2 border border-slate-300 rounded-lg outline-none focus:ring-2 focus:ring-blue-400" required>
                        <option value="">-- Pilih Cluster --</option>
                        @foreach($categories as $category)
                            <option value="{{ $category->id }}" {{ old('category_id', $property->category_id) == $category->id ? 'selected' : '' }}>{{ $category->name }}</option>
                        @endforeach
                    </select>
                </div>

                <div class="space-y-2">
                    <label class="text-sm font-semibold text-slate-700">Tipe Bangunan</label>
                    <select name="type_id" class="w-full px-4 py-2 border border-slate-300 rounded-lg outline-none focus:ring-2 focus:ring-blue-400">
                        <option value="">-- Pilih Tipe --</option>
                        @foreach($types as $type)
                            <option value="{{ $type->id }}" {{ old('type_id', $property->type_id) == $type->id ? 'selected' : '' }}>{{ $type->name }}</option>
                        @endforeach
                    </select>
                </div>

                <div class="grid grid-cols-2 gap-4">
                    <div class="space-y-2">
                        <label class="text-sm font-semibold text-slate-700">Kamar Tidur</label>
                        <input type="number" name="bedrooms" value="{{ old('bedrooms', $property->bedrooms) }}" class="w-full px-4 py-2 border border-slate-300 rounded-lg outline-none">
                    </div>
                    <div class="space-y-2">
                        <label class="text-sm font-semibold text-slate-700">Kamar Mandi</label>
                        <input type="number" name="bathrooms" value="{{ old('bathrooms', $property->bathrooms) }}" class="w-full px-4 py-2 border border-slate-300 rounded-lg outline-none">
                    </div>
                </div>
                <div class="grid grid-cols-2 gap-4">
                    <div class="space-y-2">
                        <label class="text-sm font-semibold text-slate-700">Luas Bangunan (m²)</label>
                        <input type="number" name="building_area" value="{{ old('building_area', $property->building_area) }}" class="w-full px-4 py-2 border border-slate-300 rounded-lg outline-none">
                    </div>
                    <div class="space-y-2">
                        <label class="text-sm font-semibold text-slate-700">Luas Tanah (m²)</label>
                        <input type="number" name="land_area" value="{{ old('land_area', $property->land_area) }}" class="w-full px-4 py-2 border border-slate-300 rounded-lg outline-none">
                    </div>
                </div>
            </div>

            <div class="mt-6 space-y-2">
                <label class="text-sm font-semibold text-slate-700">Deskripsi <span class="text-red-500">*</span></label>
                <textarea name="description" rows="4" class="w-full px-4 py-2 border border-slate-300 rounded-lg outline-none focus:ring-2 focus:ring-blue-400 @error('description') border-red-500 @enderror" placeholder="Tuliskan detail unit di sini...">{{ old('description', $property->description) }}</textarea>
                @error('description')
                    <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                @enderror
            </div>

            <div class="mt-6 bg-gray-50 p-6 rounded-xl border border-gray-100">
    <h3 class="text-md font-bold text-gray-800 mb-4">Gallery Foto Unit</h3>

    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">

        <div class="bg-white p-4 rounded-xl border border-gray-200/60 shadow-sm">
    <label class="block text-sm font-semibold text-gray-700 mb-2">Foto Utama (Thumbnail)</label>
    <div class="mb-3 w-32 h-24 bg-gray-100 rounded-lg overflow-hidden flex items-center justify-center border border-gray-200">
        @if($property->image && file_exists(public_path('uploads/properties/' . $property->image)))
            <img id="preview_image" src="{{ asset('uploads/properties/' . $property->image) }}" class="w-full h-full object-cover">
        @else
            <img id="preview_image" class="w-full h-full object-cover hidden">
            <span id="text_image" class="text-xs text-gray-400 italic p-2 text-center">Belum ada foto</span>
        @endif
    </div>
    <input type="file" name="image" onchange="previewFile('image')" class="w-full text-xs text-gray-500 file:mr-4 file:py-2 file:px-4 file:rounded-lg file:border-0 file:text-xs file:font-semibold file:bg-blue-50 file:text-blue-700 hover:file:bg-blue-100">
</div>

<div class="bg-white p-4 rounded-xl border border-gray-200/60 shadow-sm">
    <label class="block text-sm font-semibold text-gray-700 mb-2">Foto Kamar Tidur</label>
    <div class="mb-3 w-32 h-24 bg-gray-100 rounded-lg overflow-hidden flex items-center justify-center border border-gray-200">
        @if($property->image_living_room && file_exists(public_path('uploads/properties/' . $property->image_living_room)))
            <img id="preview_image_living_room" src="{{ asset('uploads/properties/' . $property->image_living_room) }}" class="w-full h-full object-cover">
        @else
            <img id="preview_image_living_room" class="w-full h-full object-cover hidden">
            <span id="text_image_living_room" class="text-xs text-gray-400 italic p-2 text-center">Belum ada foto</span>
        @endif
    </div>
    <input type="file" name="image_living_room" onchange="previewFile('image_living_room')" class="w-full text-xs text-gray-500 file:mr-4 file:py-2 file:px-4 file:rounded-lg file:border-0 file:text-xs file:font-semibold file:bg-blue-50 file:text-blue-700 hover:file:bg-blue-100">
</div>

<div class="bg-white p-4 rounded-xl border border-gray-200/60 shadow-sm">
    <label class="block text-sm font-semibold text-gray-700 mb-2">Foto Kamar Mandi</label>
    <div class="mb-3 w-32 h-24 bg-gray-100 rounded-lg overflow-hidden flex items-center justify-center border border-gray-200">
        @if($property->image_bathroom && file_exists(public_path('uploads/properties/' . $property->image_bathroom)))
            <img id="preview_image_bathroom" src="{{ asset('uploads/properties/' . $property->image_bathroom) }}" class="w-full h-full object-cover">
        @else
            <img id="preview_image_bathroom" class="w-full h-full object-cover hidden">
            <span id="text_image_bathroom" class="text-xs text-gray-400 italic p-2 text-center">Belum ada foto</span>
        @endif
    </div>
    <input type="file" name="image_bathroom" onchange="previewFile('image_bathroom')" class="w-full text-xs text-gray-500 file:mr-4 file:py-2 file:px-4 file:rounded-lg file:border-0 file:text-xs file:font-semibold file:bg-blue-50 file:text-blue-700 hover:file:bg-blue-100">
</div>

<div class="bg-white p-4 rounded-xl border border-gray-200/60 shadow-sm">
    <label class="block text-sm font-semibold text-gray-700 mb-2">Foto Eksterior / Luar</label>
    <div class="mb-3 w-32 h-24 bg-gray-100 rounded-lg overflow-hidden flex items-center justify-center border border-gray-200">
        @if($property->image_exterior && file_exists(public_path('uploads/properties/' . $property->image_exterior)))
            <img id="preview_image_exterior" src="{{ asset('uploads/properties/' . $property->image_exterior) }}" class="w-full h-full object-cover">
        @else
            <img id="preview_image_exterior" class="w-full h-full object-cover hidden">
            <span id="text_image_exterior" class="text-xs text-gray-400 italic p-2 text-center">Belum ada foto</span>
        @endif
    </div>
    <input type="file" name="image_exterior" onchange="previewFile('image_exterior')" class="w-full text-xs text-gray-500 file:mr-4 file:py-2 file:px-4 file:rounded-lg file:border-0 file:text-xs file:font-semibold file:bg-blue-50 file:text-blue-700 hover:file:bg-blue-100">
</div>

<div class="mt-6">
    <button type="submit" class="w-full bg-blue-600 hover:bg-blue-700 text-white font-bold py-2.5 px-4 rounded-xl transition-all shadow-md">
        Simpan Perubahan
    </button>
</div>


        </form>
    </div>
</div>

<script>
function previewFile(fieldName) {
    const fileInput = document.querySelector(`input[name="${fieldName}"]`);
    const previewImg = document.getElementById(`preview_${fieldName}`);
    const textLabel = document.getElementById(`text_${fieldName}`);

    if (fileInput.files && fileInput.files[0]) {
        const reader = new FileReader();

        reader.onload = function(e) {
            previewImg.src = e.target.result;
            previewImg.classList.remove('hidden');
            if (textLabel) {
                textLabel.classList.add('hidden');
            }
        }

        reader.readAsDataURL(fileInput.files[0]);
    }
}
</script>
@endsection
