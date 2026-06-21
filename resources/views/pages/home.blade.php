@extends('layouts.app')

@section('title', 'White House Premiere - Properti Premium Terpercaya')

@section('content')
<!-- Hero Section -->
<section class="relative h-screen flex items-center justify-center overflow-hidden">
    <!-- Background Image -->
    <div class="absolute inset-0">
        <img src="https://images.unsplash.com/photo-1600596542815-ffad4c1539a9?w=1920"
             alt="Luxury Property"
             class="w-full h-full object-cover">
        <div class="absolute inset-0 bg-gradient-to-r from-primary-900/80 to-primary-900/40"></div>
    </div>

    <!-- Content -->
    <div class="relative z-10 max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 text-center">
        <span class="inline-block bg-gold-500/20 text-gold-400 px-6 py-2 rounded-full text-sm font-semibold mb-6 border border-gold-500/30">
            Properti Premium #1 di Indonesia
        </span>
        <h1 class="font-display text-4xl md:text-5xl lg:text-7xl font-bold text-white mb-6 leading-tight">
            Wujudkan Hunian<br>
            <span class="text-gold-400">Impian Anda</span>
        </h1>
        <p class="text-xl text-gray-200 mb-10 max-w-2xl mx-auto leading-relaxed">
            Temukan koleksi properti premium eksklusif dengan lokasi strategis dan desain arsitektur berkelas dunia.
        </p>
        <div class="flex flex-col sm:flex-row gap-4 justify-center">
            <a href="{{ route('project') }}"
               class="bg-gold-500 hover:bg-gold-600 text-white px-8 py-4 rounded-full font-semibold text-lg transition-all transform hover:scale-105 shadow-xl inline-flex items-center justify-center">
                <span>Lihat Properti</span>
                <i class="fas fa-arrow-right ml-2"></i>
            </a>
            <a href="{{ route('project') }}"
               class="bg-white/10 hover:bg-white/20 text-white border-2 border-white/30 px-8 py-4 rounded-full font-semibold text-lg transition-all backdrop-blur-sm inline-flex items-center justify-center">
                <i class="fas fa-building mr-2"></i>
                <span>Lihat Properti</span>
            </a>
        </div>
    </div>

    <!-- Scroll Indicator -->
    <div class="absolute bottom-10 left-1/2 transform -translate-x-1/2 animate-bounce">
        <i class="fas fa-chevron-down text-white text-2xl"></i>
    </div>
</section>

<section class="bg-primary-900 py-16">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="grid grid-cols-2 lg:grid-cols-4 gap-8">
            <div class="text-center">
                <div class="font-display text-4xl md:text-5xl font-bold text-gold-400 mb-2">150+</div>
                <div class="text-gray-300 font-medium">Properti Terjual</div>
            </div>

            <div class="text-center">
                <div class="font-display text-4xl md:text-5xl font-bold text-gold-400 mb-2">80+</div>
                <div class="text-gray-300 font-medium">Klien Puas</div>
            </div>

            <div class="text-center">
                <div class="font-display text-4xl md:text-5xl font-bold text-gold-400 mb-2">20+</div>
                <div class="text-gray-300 font-medium">Kota Besar</div>
            </div>

            <div class="text-center">
                <div class="font-display text-4xl md:text-5xl font-bold text-gold-400 mb-2">15+</div>
                <div class="text-gray-300 font-medium">Tahun Pengalaman</div>
            </div>
        </div>
    </div>
</section>

<!-- About Section -->
<section class="py-24 bg-white">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="grid lg:grid-cols-2 gap-16 items-center">
            <div class="relative">
                <img src="https://images.unsplash.com/photo-1600607687939-ce8a6c25118c?w=800"
                     alt="About White House Premiere"
                     class="rounded-2xl shadow-2xl">
                <div class="absolute -bottom-8 -right-8 bg-gold-500 text-white p-8 rounded-2xl shadow-xl hidden md:block">
                    <div class="font-display text-4xl font-bold">15+</div>
                    <div class="text-sm">Tahun Pengalaman</div>
                </div>
            </div>
            <div>
                <span class="text-gold-500 font-semibold tracking-wider uppercase">Tentang Kami</span>
                <h2 class="font-display text-3xl md:text-4xl font-bold text-gray-900 mt-4 mb-6">
                    Partner Terpercaya untuk Properti Premium
                </h2>
                <p class="text-gray-600 leading-relaxed mb-6">
                    White House Premiere adalah perusahaan properti premium yang telah melayani ribuan klien sejak 2008.
                    Kami berkomitmen untuk memberikan properti berkualitas tinggi dengan pelayanan terbaik.
                </p>
                <p class="text-gray-600 leading-relaxed mb-8">
                    Dengan tim profesional yang berpengalaman, kami membantu Anda menemukan hunian impian atau
                    investasi properti yang menguntungkan.
                </p>
                <div class="grid grid-cols-2 gap-6 mb-8">
                    <div class="flex items-center space-x-3">
                        <div class="w-12 h-12 bg-primary-100 rounded-lg flex items-center justify-center">
                            <i class="fas fa-check text-primary-600 text-xl"></i>
                        </div>
                        <span class="font-medium text-gray-800">Properti Terverifikasi</span>
                    </div>
                    <div class="flex items-center space-x-3">
                        <div class="w-12 h-12 bg-primary-100 rounded-lg flex items-center justify-center">
                            <i class="fas fa-shield-alt text-primary-600 text-xl"></i>
                        </div>
                        <span class="font-medium text-gray-800">Transaksi Aman</span>
                    </div>
                    <div class="flex items-center space-x-3">
                        <div class="w-12 h-12 bg-primary-100 rounded-lg flex items-center justify-center">
                            <i class="fas fa-headset text-primary-600 text-xl"></i>
                        </div>
                        <span class="font-medium text-gray-800">Support 24/7</span>
                    </div>
                    <div class="flex items-center space-x-3">
                        <div class="w-12 h-12 bg-primary-100 rounded-lg flex items-center justify-center">
                            <i class="fas fa-star text-primary-600 text-xl"></i>
                        </div>
                        <span class="font-medium text-gray-800">Rating Terbaik</span>
                    </div>
                </div>
                <a href="{{ route('contact') }}" class="inline-flex items-center text-gold-600 font-semibold hover:text-gold-700 transition-colors">
                    Pelajari Lebih Lanjut
                    <i class="fas fa-arrow-right ml-2"></i>
                </a>
            </div>
        </div>
    </div>
</section>

<!-- Featured Properties -->
<section class="py-24 bg-gray-50">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="text-center mb-16">
            <span class="text-gold-500 font-semibold tracking-wider uppercase">Properti Unggulan</span>
            <h2 class="font-display text-3xl md:text-4xl font-bold text-gray-900 mt-4 mb-6">
                Koleksi Properti Premium
            </h2>
            <p class="text-gray-600 max-w-2xl mx-auto">
                Temukan pilihan properti eksklusif dengan desain modern dan lokasi strategis.
            </p>
        </div>

        <div class="grid md:grid-cols-2 lg:grid-cols-3 gap-8">
            @foreach($featuredProjects as $project)
            <div class="bg-white rounded-2xl overflow-hidden shadow-lg hover:shadow-2xl transition-all duration-300 group">
                <div class="relative overflow-hidden">
                    <img src="{{ $project->image ? asset('uploads/properties/' . $project->image) : asset('images/no-image.svg') }}"
                         alt="{{ $project->name }}"
                         class="w-full h-64 object-cover group-hover:scale-110 transition-transform duration-500"
                         onerror="this.src='{{ asset('images/no-image.svg') }}'">

                    <div class="absolute top-4 left-4">
                        <span class="bg-gold-500 text-white px-4 py-1 rounded-full text-sm font-semibold shadow-md">
                            {{ $project->category->name ?? 'Rumah' }}
                        </span>
                    </div>

                    <button onclick="shareProperty('{{ str_replace("'", "\'", $project->name) }}', '{{ route('project.show', $project->id) }}')"
                            class="absolute top-4 right-4 w-9 h-9 bg-white/80 backdrop-blur-sm rounded-full flex items-center justify-center text-gray-600 hover:text-primary-600 transition-colors shadow-sm cursor-pointer z-10"
                            title="Bagikan">
                        <i class="fas fa-share-alt text-sm"></i>
                    </button>

                    <div class="absolute inset-0 bg-gradient-to-t from-black/60 to-transparent opacity-0 group-hover:opacity-100 transition-opacity flex items-end justify-center pb-6">
                        <a href="{{ route('project.show', $project->id) }}"
                           class="bg-white text-primary-600 px-6 py-2 rounded-full font-semibold transform translate-y-4 group-hover:translate-y-0 transition-transform">
                            Lihat Detail
                        </a>
                    </div>
                </div>
                <div class="p-6">
                    <div class="flex items-center text-gray-500 text-sm mb-2">
                        <i class="fas fa-map-marker-alt mr-2"></i>
                        {{ $project->location }}
                    </div>
                    <h3 class="font-display font-bold text-xl text-gray-900 mb-3">{{ $project->name }}</h3>
                    <div class="flex items-center space-x-4 text-gray-600 text-sm mb-4">
                        <span class="flex items-center">
                            <i class="fas fa-bed mr-1"></i> {{ $project->bedrooms }} Kamar
                        </span>
                        <span class="flex items-center">
                            <i class="fas fa-bath mr-1"></i> {{ $project->bathrooms }} Bathroom
                        </span>
                            <span class="flex items-center">
                                <i class="fas fa-ruler-combined mr-1"></i> {{ $project->building_area }} m&sup2;
                            </span>
                    </div>
                    <div class="flex items-center justify-between pt-4 border-t border-gray-100">
    <span class="font-display font-bold text-xl text-primary-600">
        Rp {{ number_format($project->price, 0, ',', '.') }}
    </span>
    <a href="{{ route('project.show', $project->id) }}" class="text-gold-500 hover:text-gold-600 font-semibold">
        <i class="fas fa-arrow-right"></i>
    </a>
                </div>
                </div>
            </div>
            @endforeach
        </div>

        <div class="text-center mt-12">
            <a href="{{ route('project') }}"
               class="inline-flex items-center bg-primary-600 hover:bg-primary-700 text-white px-8 py-4 rounded-full font-semibold transition-all transform hover:scale-105">
                Lihat Semua Properti
                <i class="fas fa-arrow-right ml-2"></i>
            </a>
        </div>
    </div>
</section>

<!-- Services Section -->
<section class="py-24 bg-white">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="text-center mb-16">
            <span class="text-gold-500 font-semibold tracking-wider uppercase">Layanan Kami</span>
            <h2 class="font-display text-3xl md:text-4xl font-bold text-gray-900 mt-4 mb-6">
                Solusi Properti Lengkap
            </h2>
        </div>

        <div class="grid md:grid-cols-2 lg:grid-cols-4 gap-8">
            <div class="text-center p-8 rounded-2xl hover:bg-gray-50 transition-colors group">
                <div class="w-20 h-20 bg-primary-100 rounded-2xl flex items-center justify-center mx-auto mb-6 group-hover:bg-primary-600 transition-colors">
                    <i class="fas fa-home text-3xl text-primary-600 group-hover:text-white transition-colors"></i>
                </div>
                <h3 class="font-display font-bold text-xl text-gray-900 mb-3">Jual Beli Properti</h3>
                <p class="text-gray-600">Layanan jual beli properti dengan proses transparan dan aman.</p>
            </div>
            <div class="text-center p-8 rounded-2xl hover:bg-gray-50 transition-colors group">
                <div class="w-20 h-20 bg-primary-100 rounded-2xl flex items-center justify-center mx-auto mb-6 group-hover:bg-primary-600 transition-colors">
                    <i class="fas fa-key text-3xl text-primary-600 group-hover:text-white transition-colors"></i>
                </div>
                <h3 class="font-display font-bold text-xl text-gray-900 mb-3">Sewa Properti</h3>
                <p class="text-gray-600">Pilihan properti sewa berkualitas untuk kebutuhan Anda.</p>
            </div>
            <div class="text-center p-8 rounded-2xl hover:bg-gray-50 transition-colors group">
                <div class="w-20 h-20 bg-primary-100 rounded-2xl flex items-center justify-center mx-auto mb-6 group-hover:bg-primary-600 transition-colors">
                    <i class="fas fa-chart-line text-3xl text-primary-600 group-hover:text-white transition-colors"></i>
                </div>
                <h3 class="font-display font-bold text-xl text-gray-900 mb-3">Investasi Properti</h3>
                <p class="text-gray-600">Konsultasi investasi properti dengan ROI optimal.</p>
            </div>
            <div class="text-center p-8 rounded-2xl hover:bg-gray-50 transition-colors group">
                <div class="w-20 h-20 bg-primary-100 rounded-2xl flex items-center justify-center mx-auto mb-6 group-hover:bg-primary-600 transition-colors">
                    <i class="fas fa-file-shield text-3xl text-primary-600 group-hover:text-white transition-colors"></i>
                </div>
                <h3 class="font-display font-bold text-xl text-gray-900 mb-3">Sertifikasi & Legalitas</h3>
                <p class="text-gray-600">Setiap properti memiliki dokumen legal lengkap dan terverifikasi untuk keamanan transaksi.</p>
            </div>
        </div>
    </div>
</section>

<!-- CTA Section -->
<section class="py-24 bg-primary-900 relative overflow-hidden">
    <div class="absolute inset-0 opacity-10">
        <img src="https://images.unsplash.com/photo-1600585154340-be6161a56a0c?w=1920"
             alt=""
             class="w-full h-full object-cover">
    </div>
    <div class="relative max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 text-center">
        <h2 class="font-display text-3xl md:text-4xl lg:text-5xl font-bold text-white mb-6">
            Siap Menemukan Properti Impian?
        </h2>
        <p class="text-xl text-gray-300 mb-10 max-w-2xl mx-auto">
            Tim profesional kami siap membantu Anda menemukan properti yang sesuai dengan kebutuhan dan budget Anda.
        </p>
        <div class="flex flex-col sm:flex-row gap-4 justify-center">
            <a href="{{ route('contact') }}"
               class="bg-gold-500 hover:bg-gold-600 text-white px-8 py-4 rounded-full font-semibold text-lg transition-all transform hover:scale-105 inline-flex items-center justify-center">
                <i class="fab fa-whatsapp mr-2 text-xl"></i>
                Konsultasi Gratis
            </a>
            <a href="{{ route('project') }}"
               class="bg-white/10 hover:bg-white/20 text-white border-2 border-white/30 px-8 py-4 rounded-full font-semibold text-lg transition-all backdrop-blur-sm inline-flex items-center justify-center">
                Lihat Katalog
            </a>
        </div>
    </div>
</section>

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
