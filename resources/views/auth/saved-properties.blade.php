@extends('layouts.app')

@section('title', 'Properti Tersimpan - White House Premiere')

@section('content')
<div class="min-h-screen bg-gray-50">
    <div class="bg-gradient-to-r from-blue-800 to-blue-900 text-white">
        <div class="container mx-auto px-4 py-8">
            <div class="flex items-center space-x-4">
                <a href="{{ route('dashboard') }}" class="text-blue-200 hover:text-white">
                    <i class="fas fa-arrow-left text-xl"></i>
                </a>
                <div>
                    <h1 class="text-2xl font-bold">Properti Tersimpan</h1>
                    <p class="text-blue-200">Koleksi properti favorit Anda</p>
                </div>
            </div>
        </div>
    </div>

    <div class="container mx-auto px-4 py-8">
        @if($savedProperties->count() > 0)
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
                @foreach($savedProperties as $item)
                <div class="bg-white rounded-2xl overflow-hidden shadow-sm border border-slate-100 group">
                    <div class="relative h-48 w-full bg-slate-100 overflow-hidden">
                        <img src="{{ asset('uploads/properties/' . ($item->image ?? 'placeholder.jpg')) }}"
                             alt="{{ $item->name }}"
                             class="w-full h-full object-cover transition-all duration-300 group-hover:scale-105">
                        <div class="absolute top-4 right-4 z-10">
                            <button onclick="toggleFavorite({{ $item->id }}, this)"
                                    class="w-9 h-9 bg-white/80 backdrop-blur-sm rounded-full flex items-center justify-center text-red-500 shadow-sm cursor-pointer">
                                <i class="fas fa-heart"></i>
                            </button>
                        </div>
                    </div>
                    <div class="p-5">
                        <div class="flex items-center text-slate-400 text-xs mb-2">
                            <i class="fas fa-map-marker-alt text-primary-500 mr-1.5"></i>
                            <span>{{ $item->location ?? 'Tapos, Depok' }}</span>
                        </div>
                        <h3 class="font-display font-bold text-lg text-slate-800 mb-3">{{ $item->name }}</h3>
                        <div class="flex items-center justify-between pt-1">
                            <div class="font-display font-extrabold text-primary-600 text-base">
                                Rp {{ number_format($item->price, 0, ',', '.') }}
                            </div>
                            <a href="/project/{{ $item->id }}" class="text-gold-600 hover:text-gold-700 font-bold text-xs flex items-center gap-1 transition-all">
                                Detail <i class="fas fa-arrow-right text-[10px]"></i>
                            </a>
                        </div>
                    </div>
                </div>
                @endforeach
            </div>
        @else
            <div class="text-center py-16">
                <div class="w-20 h-20 bg-gray-200 rounded-full flex items-center justify-center mx-auto mb-6">
                    <i class="fas fa-heart text-gray-400 text-3xl"></i>
                </div>
                <h2 class="text-2xl font-bold text-gray-800 mb-3">Belum Ada Properti Tersimpan</h2>
                <p class="text-gray-500 mb-6">Temukan properti impian Anda dan simpan dengan mengklik ikon hati.</p>
                <a href="{{ route('project') }}" class="bg-blue-600 text-white px-8 py-3 rounded-lg font-semibold hover:bg-blue-700 transition-colors inline-block">
                    Jelajahi Properti
                </a>
            </div>
        @endif
    </div>
</div>
@endsection

@push('scripts')
<script>
function toggleFavorite(propertyId, btn) {
    fetch('/favorite/' + propertyId, {
        method: 'POST',
        headers: {
            'X-CSRF-TOKEN': '{{ csrf_token() }}',
            'Content-Type': 'application/json',
            'Accept': 'application/json'
        }
    })
    .then(response => response.json())
    .then(data => {
        if (data.status === 'removed') {
            btn.closest('.group').remove();
        }
    });
}
</script>
@endpush
