@extends('layouts.app')

@section('title', 'Project - White House Premiere')

@section('content')
@php
    $savedIds = Auth::check() ? Auth::user()->savedProperties()->pluck('property_id')->toArray() : [];
@endphp
<section class="relative h-[50vh] flex items-center justify-center overflow-hidden">
    <div class="absolute inset-0">
        <img src="https://images.unsplash.com/photo-1600585154340-be6161a56a0c?w=1920"
             alt="Our Projects"
             class="w-full h-full object-cover">
        <div class="absolute inset-0 bg-primary-900/70"></div>
    </div>
    <div class="relative z-10 text-center">
        <h1 class="font-display text-4xl md:text-5xl lg:text-6xl font-bold text-white mb-4">Our Projects</h1>
        <p class="text-xl text-gray-200">Koleksi properti premium pilihan terbaik</p>
    </div>
</section>

<section class="py-16 bg-gray-50">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 space-y-12">

    @forelse($clusters as $cluster)
        @if($cluster->properties->count() > 0)
        @php $total = $cluster->properties->count(); $visible = min(3, $total); @endphp
        <div x-data="{ expanded: false }">
            <div class="flex items-center gap-3 mb-6">
                <h2 class="font-display text-2xl font-bold text-slate-800">{{ $cluster->name }}</h2>
                <span class="px-3 py-1 bg-primary-100 text-primary-700 text-xs font-bold rounded-full">{{ $total }} Unit</span>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
            @foreach($cluster->properties as $idx => $item)
                @php $isSold = ($item->status ?? '') === 'sold'; @endphp
                <div class="bg-white rounded-2xl overflow-hidden shadow-sm border border-slate-100 group relative {{ $isSold ? 'opacity-60' : '' }}"
                     @if($idx >= 3) x-show="expanded" x-transition:enter="transition ease-out duration-300" x-transition:enter-start="opacity-0 scale-95" x-transition:enter-end="opacity-100 scale-100" x-cloak @endif>

                    <div class="relative h-60 w-full bg-slate-100 overflow-hidden">
                        <img src="{{ $item->image ? asset('uploads/properties/' . $item->image) : asset('images/no-image.svg') }}"
                             alt="{{ $item->name ?? 'Foto Properti' }}"
                             class="w-full h-full object-cover transition-all duration-300 group-hover:scale-105"
                             onerror="this.onerror=null; this.src='{{ asset('images/no-image.svg') }}'">

                        @if($isSold)
                        <div class="absolute inset-0 z-20 flex items-center justify-center">
                            <span class="bg-red-600 text-white font-black text-sm px-5 py-2 rounded-lg shadow-lg tracking-wider">SOLD OUT</span>
                        </div>
                        @endif

                        <div class="absolute top-4 right-4 z-10 flex flex-col gap-2">
                            <button onclick="shareProperty('{{ str_replace("'", "\'", $item->name) }}', '{{ route('project.show', $item->id) }}')"
                                    class="w-9 h-9 bg-white/80 backdrop-blur-sm rounded-full flex items-center justify-center text-gray-600 hover:text-primary-600 transition-colors shadow-sm cursor-pointer"
                                    title="Bagikan">
                                <i class="fas fa-share-alt"></i>
                            </button>
                            @auth
                            <button onclick="toggleFav({{ $item->id }}, this)"
                                    class="w-9 h-9 bg-white/80 backdrop-blur-sm rounded-full flex items-center justify-center transition-colors shadow-sm cursor-pointer
                                    {{ in_array($item->id, $savedIds) ? 'text-red-500' : 'text-gray-600 hover:text-red-500' }}">
                                <i class="{{ in_array($item->id, $savedIds) ? 'fas' : 'far' }} fa-heart"></i>
                            </button>
                            @else
                            <a href="{{ route('login') }}"
                               class="w-9 h-9 bg-white/80 backdrop-blur-sm rounded-full flex items-center justify-center text-gray-600 hover:text-red-500 transition-colors shadow-sm">
                                <i class="far fa-heart"></i>
                            </a>
                            @endauth
                        </div>
                    </div>

                    <div class="p-5">
                        <div class="flex items-center text-slate-400 text-xs mb-2">
                            <i class="fas fa-map-marker-alt text-primary-500 mr-1.5"></i>
                            <span>{{ $item->location }}</span>
                        </div>

                        <h3 class="font-display font-bold text-lg text-slate-800 mb-3">
                            {{ $item->name }}
                        </h3>

                        <div class="flex items-center space-x-4 text-slate-500 text-xs mb-5 border-b border-slate-50 pb-4">
                            <div class="flex items-center">
                                <i class="fas fa-bed mr-1.5 text-slate-400"></i>
                                <span>{{ $item->bedrooms ?? 0 }} Kamar</span>
                            </div>
                            <div class="flex items-center">
                                <i class="fas fa-bath mr-1.5 text-slate-400"></i>
                                <span>{{ $item->bathrooms ?? 0 }} Bathroom</span>
                            </div>
                            <div class="flex items-center">
                                <i class="fas fa-ruler-combined mr-1.5 text-slate-400"></i>
                                <span>{{ $item->building_area ?? 0 }} m²</span>
                            </div>
                        </div>

                        <div class="flex items-center justify-between pt-1">
                            <div class="font-display font-extrabold text-primary-600 text-base">
                                Rp {{ number_format($item->price ?? 0, 0, ',', '.') }}
                            </div>
                            @if($isSold)
                            <span class="text-red-400 font-bold text-xs">Tidak Tersedia</span>
                            @else
                            <a href="{{ route('project.show', $item->id) }}" class="text-gold-600 hover:text-gold-700 font-bold text-xs flex items-center gap-1 transition-all">
                                Detail <i class="fas fa-arrow-right text-[10px]"></i>
                            </a>
                            @endif
                        </div>
                    </div>

                </div>
            @endforeach
            </div>

            @if($total > 3)
            <div class="mt-6 text-center">
                <button @click="expanded = !expanded"
                        class="inline-flex items-center gap-2 px-6 py-3 bg-white border border-primary-200 text-primary-700 rounded-full font-semibold text-sm hover:bg-primary-50 transition-all shadow-sm">
                    <span x-show="!expanded">Lihat Semua Unit ({{ $total }})</span>
                    <span x-show="expanded">Tampilkan Lebih Sedikit</span>
                    <i class="fas fa-chevron-down text-xs transition-transform duration-300" :class="{ 'rotate-180': expanded }"></i>
                </button>
            </div>
            @endif
        </div>
        @endif
    @empty
        <div class="text-center py-20">
            <p class="text-slate-400 text-lg">Belum ada properti tersedia.</p>
        </div>
    @endforelse

    </div>
</section>

<section class="py-16 bg-primary-900">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 text-center">
        <h2 class="font-display text-3xl md:text-4xl font-bold text-white mb-4">
            Tidak Menemukan yang Anda Cari?
        </h2>
        <p class="text-gray-300 mb-8 max-w-2xl mx-auto">
            Hubungi tim kami untuk mendapatkan rekomendasi properti sesuai kebutuhan Anda.
        </p>
        <a href="{{ route('contact') }}"
           class="inline-flex items-center bg-gold-500 hover:bg-gold-600 text-white px-8 py-4 rounded-full font-semibold transition-all transform hover:scale-105">
            <i class="fab fa-whatsapp mr-2 text-xl"></i>
            Hubungi Kami
        </a>
    </div>
</section>
@push('scripts')
<script>
function toggleFav(propertyId, btn) {
    fetch('{{ url("/favorite") }}/' + propertyId, {
        method: 'POST',
        headers: {
            'X-CSRF-TOKEN': '{{ csrf_token() }}',
            'Content-Type': 'application/json',
            'Accept': 'application/json'
        }
    })
    .then(r => r.json())
    .then(data => {
        const icon = btn.querySelector('i');
        if (data.status === 'added') {
            icon.className = 'fas fa-heart';
            btn.classList.add('text-red-500');
            btn.classList.remove('text-gray-600');
        } else {
            icon.className = 'far fa-heart';
            btn.classList.remove('text-red-500');
            btn.classList.add('text-gray-600');
        }
    });
}
</script>
@endpush

@push('scripts')
<script>
function shareProperty(name, url) {
    if (navigator.share) {
        navigator.share({
            title: name,
            text: 'Lihat properti ' + name + ' dari White House Premiere',
            url: url
        }).catch(() => {});
    } else {
        navigator.clipboard.writeText(url).then(() => {
            alert('Link properti berhasil disalin!');
        }).catch(() => {
            prompt('Salin link ini:', url);
        });
    }
}
</script>
@endpush
@endsection