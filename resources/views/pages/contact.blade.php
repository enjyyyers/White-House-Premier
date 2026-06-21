@extends('layouts.app')

@section('title', 'Contact - White House Premiere')

@section('content')
<!-- Hero Section -->
<section class="relative h-[50vh] flex items-center justify-center overflow-hidden">
    <div class="absolute inset-0">
        <img src="https://images.unsplash.com/photo-1600566753190-17f0baa2a6c3?w=1920"
             alt="Contact"
             class="w-full h-full object-cover">
        <div class="absolute inset-0 bg-primary-900/70"></div>
    </div>
    <div class="relative z-10 text-center">
        <h1 class="font-display text-4xl md:text-5xl lg:text-6xl font-bold text-white mb-4">Hubungi Kami</h1>
        <p class="text-xl text-gray-200">Kami siap membantu mewujudkan properti impian Anda</p>
    </div>
</section>

<!-- Contact Section -->
<section class="py-20 bg-white">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="grid lg:grid-cols-3 gap-12">
            <!-- Contact Info -->
            <div class="lg:col-span-1">
                <h2 class="font-display text-2xl font-bold text-gray-900 mb-8">Informasi Kontak</h2>

                <div class="space-y-6">
                    <div class="flex items-start space-x-4">
                        <div class="w-12 h-12 bg-primary-100 rounded-xl flex items-center justify-center shrink-0">
                            <i class="fas fa-map-marker-alt text-primary-600 text-xl"></i>
                        </div>
                        <div>
                            <h3 class="font-semibold text-gray-900 mb-1">Alamat</h3>
                            <p class="text-gray-600">{{ $contactInfo['address'] }}</p>
                        </div>
                    </div>

                    <div class="flex items-start space-x-4">
                        <div class="w-12 h-12 bg-primary-100 rounded-xl flex items-center justify-center shrink-0">
                            <i class="fas fa-phone text-primary-600 text-xl"></i>
                        </div>
                        <div>
                            <h3 class="font-semibold text-gray-900 mb-1">Telepon</h3>
                            <p class="text-gray-600">{{ $contactInfo['phone'] }}</p>
                        </div>
                    </div>

                    <div class="flex items-start space-x-4">
                        <div class="w-12 h-12 bg-green-100 rounded-xl flex items-center justify-center shrink-0">
                            <i class="fab fa-whatsapp text-green-600 text-xl"></i>
                        </div>
                        <div>
                            <h3 class="font-semibold text-gray-900 mb-1">WhatsApp</h3>
                            <p class="text-gray-600">{{ $contactInfo['whatsapp'] }}</p>
                        </div>
                    </div>

                    <div class="flex items-start space-x-4">
                        <div class="w-12 h-12 bg-primary-100 rounded-xl flex items-center justify-center shrink-0">
                            <i class="fas fa-envelope text-primary-600 text-xl"></i>
                        </div>
                        <div>
                            <h3 class="font-semibold text-gray-900 mb-1">Email</h3>
                            <p class="text-gray-600">{{ $contactInfo['email'] }}</p>
                        </div>
                    </div>

                    <div class="flex items-start space-x-4">
                        <div class="w-12 h-12 bg-primary-100 rounded-xl flex items-center justify-center shrink-0">
                            <i class="fas fa-clock text-primary-600 text-xl"></i>
                        </div>
                        <div>
                            <h3 class="font-semibold text-gray-900 mb-1">Jam Operasional</h3>
                            <p class="text-gray-600">{{ $contactInfo['hours'] }}</p>
                        </div>
                    </div>
                </div>

                <!-- Social Media -->
                <div class="mt-10">
                    <h3 class="font-semibold text-gray-900 mb-4">Ikuti Kami</h3>
                    <div class="flex space-x-4">
                        <a href="#" class="w-12 h-12 bg-primary-600 hover:bg-primary-700 rounded-full flex items-center justify-center text-white transition-colors">
                            <i class="fab fa-facebook-f"></i>
                        </a>
                        <a href="#" class="w-12 h-12 bg-primary-600 hover:bg-primary-700 rounded-full flex items-center justify-center text-white transition-colors">
                            <i class="fab fa-instagram"></i>
                        </a>
                        <a href="#" class="w-12 h-12 bg-primary-600 hover:bg-primary-700 rounded-full flex items-center justify-center text-white transition-colors">
                            <i class="fab fa-youtube"></i>
                        </a>
                        <a href="#" class="w-12 h-12 bg-primary-600 hover:bg-primary-700 rounded-full flex items-center justify-center text-white transition-colors">
                            <i class="fab fa-linkedin-in"></i>
                        </a>
                    </div>
                </div>
            </div>

            <!-- Contact Form -->
            <div class="lg:col-span-2">
                <div class="bg-gray-50 rounded-3xl p-8 md:p-12">
                    <h2 class="font-display text-2xl font-bold text-gray-900 mb-2">Kirim Pesan</h2>
                    <p class="text-gray-600 mb-8">Isi formulir di bawah ini dan tim kami akan menghubungi Anda segera.</p>

                    @if(session('success'))
                    <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded-lg mb-6">
                        {{ session('success') }}
                    </div>
                    @endif

                    <form action="{{ route('contact.submit') }}" method="POST" class="space-y-6">
                        @csrf

                        <div class="grid md:grid-cols-2 gap-6">
                            <div>
                                <label for="name" class="block text-sm font-medium text-gray-700 mb-2">Nama Lengkap *</label>
                                <input type="text"
                                       id="name"
                                       name="name"
                                       required
                                       class="w-full px-4 py-3 rounded-xl focus:ring-2 focus:ring-primary-500 focus:border-transparent transition-all @error('name') border-red-500 @else border-gray-300 @enderror"
                                       placeholder="Masukkan nama lengkap">
                                @error('name')
                                <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                                @enderror
                            </div>
                            <div>
                                <label for="email" class="block text-sm font-medium text-gray-700 mb-2">Email *</label>
                                <input type="email"
                                       id="email"
                                       name="email"
                                       required
                                       class="w-full px-4 py-3 rounded-xl focus:ring-2 focus:ring-primary-500 focus:border-transparent transition-all @error('email') border-red-500 @else border-gray-300 @enderror"
                                       placeholder="Masukkan email">
                                @error('email')
                                <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                                @enderror
                            </div>
                        </div>

                        <div class="grid md:grid-cols-2 gap-6">
                            <div>
                                <label for="phone" class="block text-sm font-medium text-gray-700 mb-2">No. Telepon *</label>
                                <input type="tel"
                                       id="phone"
                                       name="phone"
                                       required
                                       class="w-full px-4 py-3 rounded-xl focus:ring-2 focus:ring-primary-500 focus:border-transparent transition-all @error('phone') border-red-500 @else border-gray-300 @enderror"
                                       placeholder="Masukkan no. telepon">
                                @error('phone')
                                <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                                @enderror
                            </div>
                            <div>
                                <label for="subject" class="block text-sm font-medium text-gray-700 mb-2">Subjek *</label>
                                <select id="subject"
                                        name="subject"
                                        required
                                        class="w-full px-4 py-3 rounded-xl focus:ring-2 focus:ring-primary-500 focus:border-transparent transition-all @error('subject') border-red-500 @else border-gray-300 @enderror">
                                    <option value="">Pilih subjek</option>
                                    <option value="Konsultasi Properti">Konsultasi Properti</option>
                                    <option value="Jadwal Kunjungan">Jadwal Kunjungan</option>
                                    <option value="Informasi Harga">Informasi Harga</option>
                                    <option value="Kerja Sama">Kerja Sama</option>
                                    <option value="Lainnya">Lainnya</option>
                                </select>
                                @error('subject')
                                <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                                @enderror
                            </div>
                        </div>

                        <div>
                            <label for="message" class="block text-sm font-medium text-gray-700 mb-2">Pesan *</label>
                            <textarea id="message"
                                      name="message"
                                      rows="5"
                                      required
                                      class="w-full px-4 py-3 rounded-xl focus:ring-2 focus:ring-primary-500 focus:border-transparent transition-all @error('message') border-red-500 @else border-gray-300 @enderror"
                                      placeholder="Tulis pesan Anda"></textarea>
                            @error('message')
                            <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                            @enderror
                        </div>

                        <div class="flex flex-col sm:flex-row gap-4">
                            <button type="submit"
                                    class="flex-1 bg-primary-600 hover:bg-primary-700 text-white py-4 rounded-xl font-semibold transition-colors flex items-center justify-center">
                                <i class="fas fa-paper-plane mr-2"></i>
                                Kirim Pesan
                            </button>
                            <a href="https://wa.me/6281234567890"
                               class="flex-1 bg-green-500 hover:bg-green-600 text-white py-4 rounded-xl font-semibold transition-colors flex items-center justify-center">
                                <i class="fab fa-whatsapp mr-2 text-xl"></i>
                                Chat WhatsApp
                            </a>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</section>

<!-- Map Section -->
<section class="h-[500px] bg-gray-100">
    <iframe src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d3966.521260322283!2d106.8195613!3d-6.194741399999999!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x2e69f5d2e764b12d%3A0x3d2ad6e1e0e9bcc8!2sMonumen%20Nasional!5e0!3m2!1sen!2sid!4v1234567890"
            class="w-full h-full"
            frameborder="0"
            style="border:0;"
            allowfullscreen=""
            loading="lazy">
    </iframe>
</section>

<!-- Branch Offices -->
<section class="py-20 bg-gray-50">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="text-center mb-16">
            <span class="text-gold-500 font-semibold tracking-wider uppercase">Kantor Cabang</span>
            <h2 class="font-display text-3xl md:text-4xl font-bold text-gray-900 mt-4">
                Lokasi Kantor Kami
            </h2>
        </div>

        <div class="grid md:grid-cols-3 gap-8">
            @foreach($offices as $office)
            <div class="bg-white rounded-2xl p-8 shadow-lg hover:shadow-xl transition-shadow">
                <div class="w-14 h-14 bg-primary-100 rounded-xl flex items-center justify-center mb-6">
                    <i class="fas fa-building text-primary-600 text-2xl"></i>
                </div>
                <h3 class="font-display font-bold text-xl text-gray-900 mb-2">{{ $office['city'] }}</h3>
                <p class="text-gray-600 mb-4">{{ $office['address'] }}</p>
                <div class="flex items-center text-gray-600">
                    <i class="fas fa-phone mr-2"></i>
                    {{ $office['phone'] }}
                </div>
            </div>
            @endforeach
        </div>
    </div>
</section>

<!-- FAQ Section -->
<section class="py-20 bg-white">
    <div class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="text-center mb-16">
            <span class="text-gold-500 font-semibold tracking-wider uppercase">FAQ</span>
            <h2 class="font-display text-3xl md:text-4xl font-bold text-gray-900 mt-4">
                Pertanyaan yang Sering Diajukan
            </h2>
        </div>

        <div class="space-y-4" x-data="{ openFaq: null }">
            <div class="border border-gray-200 rounded-xl overflow-hidden">
                <button @click="openFaq = openFaq === 1 ? null : 1"
                        class="w-full flex items-center justify-between p-6 text-left bg-white hover:bg-gray-50 transition-colors">
                    <span class="font-semibold text-gray-900">Bagaimana cara membeli properti melalui White House Premiere?</span>
                    <i class="fas" :class="openFaq === 1 ? 'fa-minus' : 'fa-plus'" class="text-primary-600"></i>
                </button>
                <div x-show="openFaq === 1" x-collapse class="px-6 pb-6">
                    <p class="text-gray-600">Anda dapat menghubungi tim kami melalui WhatsApp atau mengisi formulir kontak. Tim kami akan membantu Anda dari awal hingga proses serah terima kunci.</p>
                </div>
            </div>

            <div class="border border-gray-200 rounded-xl overflow-hidden">
                <button @click="openFaq = openFaq === 2 ? null : 2"
                        class="w-full flex items-center justify-between p-6 text-left bg-white hover:bg-gray-50 transition-colors">
                    <span class="font-semibold text-gray-900">Apakah ada biaya konsultasi?</span>
                    <i class="fas" :class="openFaq === 2 ? 'fa-minus' : 'fa-plus'" class="text-primary-600"></i>
                </button>
                <div x-show="openFaq === 2" x-collapse class="px-6 pb-6">
                    <p class="text-gray-600">Tidak ada biaya untuk konsultasi awal. Kami siap membantu Anda menemukan properti yang sesuai dengan kebutuhan dan budget Anda secara gratis.</p>
                </div>
            </div>

            <div class="border border-gray-200 rounded-xl overflow-hidden">
                <button @click="openFaq = openFaq === 3 ? null : 3"
                        class="w-full flex items-center justify-between p-6 text-left bg-white hover:bg-gray-50 transition-colors">
                    <span class="font-semibold text-gray-900">Apakah bisa mengajukan KPR?</span>
                    <i class="fas" :class="openFaq === 3 ? 'fa-minus' : 'fa-plus'" class="text-primary-600"></i>
                </button>
                <div x-show="openFaq === 3" x-collapse class="px-6 pb-6">
                    <p class="text-gray-600">Ya, kami bekerja sama dengan berbagai bank untuk membantu proses pengajuan KPR Anda dengan bunga kompetitif dan proses yang mudah.</p>
                </div>
            </div>

            <div class="border border-gray-200 rounded-xl overflow-hidden">
                <button @click="openFaq = openFaq === 4 ? null : 4"
                        class="w-full flex items-center justify-between p-6 text-left bg-white hover:bg-gray-50 transition-colors">
                    <span class="font-semibold text-gray-900">Bagaimana cara menjadwalkan kunjungan properti?</span>
                    <i class="fas" :class="openFaq === 4 ? 'fa-minus' : 'fa-plus'" class="text-primary-600"></i>
                </button>
                <div x-show="openFaq === 4" x-collapse class="px-6 pb-6">
                    <p class="text-gray-600">Anda dapat menghubungi kami melalui formulir kontak atau WhatsApp untuk menjadwalkan kunjungan. Tim kami akan mengatur waktu yang sesuai dengan jadwal Anda.</p>
                </div>
            </div>
        </div>
    </div>
</section>
@endsection

@push('scripts')
<script src="https://cdn.jsdelivr.net/npm/@alpinejs/collapse@3.x.x/dist/cdn.min.js"></script>
@endpush
