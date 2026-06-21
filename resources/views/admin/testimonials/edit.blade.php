@extends('layouts.admin')

@section('title', 'Edit Testimoni')
@section('subtitle', 'Perbarui atau moderasi testimoni pelanggan.')

@section('content')
<div class="p-6">
    <div class="mb-6 flex items-center space-x-4">
        <a href="{{ route('admin.testimonials.index') }}" class="text-gray-400 hover:text-gray-600">
            <i class="fas fa-arrow-left text-xl"></i>
        </a>
        <div>
            <h2 class="text-2xl font-bold text-gray-800">Edit Testimonial</h2>
            <p class="text-sm text-gray-500">Dari {{ $testimonial->name }}</p>
        </div>
    </div>

    @if(session('success'))
        <div class="mb-4 p-4 bg-green-100 text-green-700 rounded-lg text-sm">{{ session('success') }}</div>
    @endif

    <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">
        <div class="lg:col-span-2">
            <div class="bg-white rounded-xl shadow-sm border border-gray-100 p-6">
                <form method="POST" action="{{ route('admin.testimonials.update', $testimonial->id) }}">
                    @csrf @method('PUT')
                    <div class="grid grid-cols-2 gap-4 mb-4">
                        <div>
                            <label class="block text-sm font-semibold text-gray-700 mb-2">Nama</label>
                            <input type="text" name="name" value="{{ old('name', $testimonial->name) }}" required class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500">
                        </div>
                        <div>
                            <label class="block text-sm font-semibold text-gray-700 mb-2">Posisi/Pekerjaan</label>
                            <input type="text" name="position" value="{{ old('position', $testimonial->position) }}" class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500">
                        </div>
                    </div>
                    <div class="mb-4">
                        <label class="block text-sm font-semibold text-gray-700 mb-2">Rating</label>
                        <div class="flex space-x-2" x-data="{ rating: {{ old('rating', $testimonial->rating) }} }">
                            @for($i = 1; $i <= 5; $i++)
                            <button type="button" @click="rating = {{ $i }}" class="text-2xl focus:outline-none">
                                <i :class="rating >= {{ $i }} ? 'fas fa-star text-yellow-500' : 'far fa-star text-gray-300'"></i>
                            </button>
                            @endfor
                            <input type="hidden" name="rating" x-model="rating">
                        </div>
                    </div>
                    <div class="mb-4">
                        <label class="block text-sm font-semibold text-gray-700 mb-2">Review</label>
                        <textarea name="review" rows="5" required class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500">{{ old('review', $testimonial->review) }}</textarea>
                    </div>
                    <div class="mb-6">
                        <label class="flex items-center space-x-3">
                            <input type="checkbox" name="is_active" value="1" {{ old('is_active', $testimonial->is_active) ? 'checked' : '' }} class="h-5 w-5 text-blue-600 rounded">
                            <span class="text-sm font-medium text-gray-700">Tampilkan di halaman publik</span>
                        </label>
                    </div>
                    <button type="submit" class="bg-blue-600 text-white px-6 py-3 rounded-lg font-semibold hover:bg-blue-700 transition-colors">
                        <i class="fas fa-save mr-2"></i> Simpan Perubahan
                    </button>
                </form>
            </div>
        </div>

        <div class="space-y-6">
            <div class="bg-white rounded-xl shadow-sm border border-gray-100 p-6">
                <h3 class="font-bold text-gray-800 mb-4">Preview</h3>
                <div class="bg-gray-50 rounded-lg p-4 text-center">
                    <div class="w-14 h-14 mx-auto bg-blue-100 rounded-full flex items-center justify-center text-blue-600 font-bold text-xl mb-3">
                        {{ substr($testimonial->name, 0, 1) }}
                    </div>
                    <div class="flex justify-center mb-2">
                        @for($i = 0; $i < 5; $i++)
                            <i class="fas fa-star{{ $i < $testimonial->rating ? ' text-yellow-500' : ' text-gray-300' }} text-sm"></i>
                        @endfor
                    </div>
                    <p class="text-sm text-gray-600 italic">"{{ Str::limit($testimonial->review, 100) }}"</p>
                    <p class="text-sm font-bold text-gray-800 mt-2">{{ $testimonial->name }}</p>
                    <p class="text-xs text-gray-400">{{ $testimonial->position ?? '' }}</p>
                </div>
            </div>

            @if(!$testimonial->is_replied || true)
            <div class="bg-white rounded-xl shadow-sm border border-gray-100 p-6">
                <h3 class="font-bold text-gray-800 mb-4">Balas Testimonial</h3>
                <form action="{{ route('admin.testimonials.reply', $testimonial->id) }}" method="POST">
                    @csrf
                    <textarea name="reply" rows="4" required class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 mb-3" placeholder="Tulis balasan...">{{ old('reply', $testimonial->reply) }}</textarea>
                    <button type="submit" class="w-full bg-blue-600 text-white py-3 rounded-lg font-semibold hover:bg-blue-700 transition-colors">
                        <i class="fas fa-paper-plane mr-2"></i> Kirim Balasan
                    </button>
                </form>
                @if($testimonial->is_replied)
                    <div class="mt-4 p-3 bg-green-50 rounded-lg border border-green-100">
                        <p class="text-xs text-green-700 font-semibold mb-1">Balasan sebelumnya:</p>
                        <p class="text-sm text-gray-700">{{ $testimonial->reply }}</p>
                    </div>
                @endif
            </div>
            @endif
        </div>
    </div>
</div>
@endsection
