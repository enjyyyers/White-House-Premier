@extends('layouts.app')

@section('title', 'Testimoni & Review - White House Premiere')

@section('content')
<style>
    .anim-fade-up { opacity: 0; transform: translateY(30px); animation: fadeUp 0.6s ease forwards; }
    .anim-fade-up:nth-child(1) { animation-delay: 0.1s; }
    .anim-fade-up:nth-child(2) { animation-delay: 0.2s; }
    .anim-fade-up:nth-child(3) { animation-delay: 0.3s; }
    .anim-fade-up:nth-child(4) { animation-delay: 0.4s; }
    .anim-fade-up:nth-child(5) { animation-delay: 0.5s; }
    .anim-fade-up:nth-child(6) { animation-delay: 0.6s; }
    @keyframes fadeUp { to { opacity: 1; transform: translateY(0); } }
    .anim-scale-in { opacity: 0; transform: scale(0.9); animation: scaleIn 0.5s ease forwards; }
    @keyframes scaleIn { to { opacity: 1; transform: scale(1); } }
</style>

<section class="relative h-[50vh] flex items-center justify-center overflow-hidden">
    <div class="absolute inset-0">
        <img src="https://images.unsplash.com/photo-1600607687939-ce8a6c25118c?w=1920" alt="Testimonials" class="w-full h-full object-cover">
        <div class="absolute inset-0 bg-primary-900/70"></div>
    </div>
    <div class="relative z-10 text-center">
        <h1 class="font-display text-5xl md:text-6xl lg:text-7xl font-bold text-white mb-4">Testimoni & Review</h1>
        <p class="text-xl md:text-2xl text-gray-200">Apa kata klien kami tentang White House Premiere</p>
    </div>
</section>

<section class="py-16 bg-white">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="grid md:grid-cols-3 gap-8">
            @foreach($reviews as $review)
            <div class="bg-gray-50 rounded-2xl p-8 text-center anim-scale-in hover:shadow-lg transition-shadow">
                <div class="text-5xl font-display font-bold text-primary-600 mb-2">{{ $review['rating'] }}</div>
                <div class="flex justify-center mb-3">
                    @for($i = 0; $i < 5; $i++)
                        @if($i < floor($review['rating']))
                            <i class="fas fa-star text-gold-500 text-2xl"></i>
                        @elseif($i < $review['rating'])
                            <i class="fas fa-star-half-alt text-gold-500 text-2xl"></i>
                        @else
                            <i class="far fa-star text-gold-500 text-2xl"></i>
                        @endif
                    @endfor
                </div>
                <div class="text-gray-600 font-medium text-lg">{{ $review['platform'] }}</div>
                <div class="text-gray-500">{{ $review['totalReviews'] }} reviews</div>
            </div>
            @endforeach
        </div>
    </div>
</section>

<section class="py-20 bg-gray-50">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="text-center mb-16">
            <span class="text-gold-500 font-semibold tracking-wider uppercase text-lg">Testimoni</span>
            <h2 class="font-display text-4xl md:text-5xl font-bold text-gray-900 mt-4">Kata Mereka Tentang Kami</h2>
        </div>

        <div class="grid md:grid-cols-2 lg:grid-cols-3 gap-8">
            @foreach($testimonials as $testimonial)
            <div class="bg-white rounded-2xl p-8 shadow-lg hover:shadow-xl transition-all duration-300 hover:-translate-y-1 anim-fade-up">
                <div class="absolute -top-4 left-8">
                    <div class="w-12 h-12 bg-gold-500 rounded-full flex items-center justify-center">
                        <i class="fas fa-quote-left text-white text-xl"></i>
                    </div>
                </div>

                <div class="flex mb-4 mt-4">
                    @for($i = 0; $i < $testimonial->rating; $i++)
                        <i class="fas fa-star text-gold-500 text-lg"></i>
                    @endfor
                    @for($i = $testimonial->rating; $i < 5; $i++)
                        <i class="far fa-star text-gold-500 text-lg"></i>
                    @endfor
                </div>

                <p class="text-gray-600 leading-relaxed text-base mb-6">"{{ $testimonial->review }}"</p>

                <div class="flex items-center">
                    <div class="w-14 h-14 rounded-full bg-blue-100 flex items-center justify-center text-blue-600 font-bold text-xl mr-4">
                        {{ substr($testimonial->name, 0, 1) }}
                    </div>
                    <div>
                        <div class="font-semibold text-gray-900 text-base">{{ $testimonial->name }}</div>
                        <div class="text-gray-500">{{ $testimonial->position ?? 'Klien' }}</div>
                    </div>
                </div>

                @if($testimonial->is_replied)
                <div class="mt-4 pt-4 border-t border-gray-100">
                    <div class="flex items-start space-x-2">
                        <div class="w-8 h-8 rounded-full bg-blue-600 flex items-center justify-center text-white font-bold text-xs shrink-0 mt-0.5">WH</div>
                        <div class="bg-blue-50 rounded-lg p-3 flex-1">
                            <p class="text-xs font-bold text-blue-700 mb-1">White House Premiere</p>
                            <p class="text-sm text-gray-700">{{ $testimonial->reply }}</p>
                        </div>
                    </div>
                </div>
                @endif
            </div>
            @endforeach
        </div>

        @if($testimonials->isEmpty())
        <div class="text-center py-12">
            <p class="text-gray-400 text-lg">Belum ada testimoni. Jadilah yang pertama!</p>
        </div>
        @endif
    </div>
</section>

<section class="py-20 bg-primary-900">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="bg-white/10 backdrop-blur-sm rounded-3xl p-12 text-center anim-scale-in">
            <h2 class="font-display text-4xl md:text-5xl font-bold text-white mb-4">Punya Pengalaman dengan Kami?</h2>
            <p class="text-gray-300 text-lg mb-8 max-w-2xl mx-auto">
                Kami sangat menghargai setiap feedback dari klien kami. Bagikan pengalaman Anda.
            </p>

            @auth
            <form action="{{ route('testimoni.store') }}" method="POST" class="max-w-xl mx-auto text-left space-y-5">
                @csrf
                <div class="grid grid-cols-2 gap-4">
                    <div>
                        <label class="block text-white font-semibold mb-2">Nama Lengkap *</label>
                        <input type="text" name="name" value="{{ Auth::user()->name }}" required class="w-full px-4 py-3 rounded-xl border-0 text-gray-900 focus:ring-2 focus:ring-gold-500">
                    </div>
                    <div>
                        <label class="block text-white font-semibold mb-2">Posisi/Pekerjaan</label>
                        <input type="text" name="position" class="w-full px-4 py-3 rounded-xl border-0 text-gray-900 focus:ring-2 focus:ring-gold-500" placeholder="Contoh: Pengusaha">
                    </div>
                </div>
                <div>
                    <label class="block text-white font-semibold mb-2">Rating</label>
                    <div class="flex space-x-2" x-data="{ rating: 5 }">
                        @for($i = 1; $i <= 5; $i++)
                        <button type="button" @click="rating = {{ $i }}" class="text-3xl focus:outline-none transition-transform hover:scale-110">
                            <i :class="rating >= {{ $i }} ? 'fas fa-star text-gold-500' : 'far fa-star text-gray-400'"></i>
                        </button>
                        @endfor
                        <input type="hidden" name="rating" x-model="rating">
                    </div>
                </div>
                <div>
                    <label class="block text-white font-semibold mb-2">Review Anda *</label>
                    <textarea name="review" rows="4" required class="w-full px-4 py-3 rounded-xl border-0 text-gray-900 focus:ring-2 focus:ring-gold-500" placeholder="Ceritakan pengalaman Anda..."></textarea>
                </div>
                <button type="submit" class="w-full bg-gold-500 hover:bg-gold-600 text-white font-bold py-4 rounded-xl text-lg transition-all transform hover:scale-[1.02]">
                    <i class="fas fa-paper-plane mr-2"></i> Kirim Review
                </button>
            </form>
            @else
            <div class="flex flex-col sm:flex-row gap-4 justify-center">
                <a href="{{ route('login') }}" class="inline-flex items-center bg-gold-500 hover:bg-gold-600 text-white px-10 py-4 rounded-full font-semibold text-lg transition-all transform hover:scale-105">
                    <i class="fas fa-pen mr-2"></i>
                    Login untuk Menulis Review
                </a>
                <a href="{{ route('contact') }}" class="inline-flex items-center bg-white/10 hover:bg-white/20 text-white border-2 border-white/30 px-10 py-4 rounded-full font-semibold text-lg transition-all">
                    Hubungi Kami
                </a>
            </div>
            @endauth
        </div>
    </div>
</section>

@if(session('success'))
<div class="fixed bottom-6 right-6 bg-green-600 text-white px-6 py-4 rounded-xl shadow-2xl z-50 anim-fade-up flex items-center space-x-3">
    <i class="fas fa-check-circle text-2xl"></i>
    <span class="font-medium">{{ session('success') }}</span>
</div>
@endif
@endsection
