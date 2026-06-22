@extends('layouts.app')

@section('title', (is_array($project) ? $project['name'] : $project->name) . ' - White House Premiere')

@section('content')
<section class="pt-24 pb-4 bg-gray-50">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <nav class="flex items-center space-x-2 text-sm">
            <a href="{{ route('home') }}" class="text-gray-500 hover:text-primary-600">Home</a>
            <i class="fas fa-chevron-right text-gray-400 text-xs"></i>
            <a href="{{ route('project') }}" class="text-gray-500 hover:text-primary-600">Project</a>
            <i class="fas fa-chevron-right text-gray-400 text-xs"></i>
            <span class="text-primary-600 font-medium">{{ $project->name ?? $project['name'] }}</span>
        </nav>
    </div>
</section>

<div x-data="{ fotoAktif: 0, bukaModal: false }" x-cloak class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 mt-4">

    <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">

        <div class="lg:col-span-2 relative group overflow-hidden bg-slate-100 rounded-2xl h-[400px] md:h-[500px] flex items-center justify-center border border-slate-200 shadow-sm">

            @if($isSold)
            <div class="absolute top-6 left-6 z-20">
                <span class="bg-red-600 text-white font-black text-sm px-5 py-2 rounded-lg shadow-lg tracking-wider">SOLD OUT</span>
            </div>
            @endif

            <img src="{{ $project->image ? asset('uploads/properties/' . $project->image) : asset('images/no-image.svg') }}"
                 x-show="fotoAktif === 0"
                 alt="{{ $project->name }}"
                 class="w-full h-full object-cover transition-all duration-500 group-hover:scale-102"
                 onerror="this.src='{{ asset('images/no-image.svg') }}'">

            @if(!empty($project->image_living_room) || !empty($project['image_living_room']))
            <img src="{{ asset('uploads/properties/' . ($project->image_living_room ?? $project['image_living_room'])) }}"
                 x-show="fotoAktif === 1"
                 alt="{{ $project->name ?? $project['name'] }}"
                 class="w-full h-full object-cover transition-all duration-500 group-hover:scale-102">
            @endif

            @if(!empty($project->image_bathroom) || !empty($project['image_bathroom']))
            <img src="{{ asset('uploads/properties/' . ($project->image_bathroom ?? $project['image_bathroom'])) }}"
                 x-show="fotoAktif === 2"
                 alt="{{ $project->name ?? $project['name'] }}"
                 class="w-full h-full object-cover transition-all duration-500 group-hover:scale-102">
            @endif

            @if(!empty($project->image_exterior) || !empty($project['image_exterior']))
            <img src="{{ asset('uploads/properties/' . ($project->image_exterior ?? $project['image_exterior'])) }}"
                 x-show="fotoAktif === 3"
                 alt="{{ $project->name ?? $project['name'] }}"
                 class="w-full h-full object-cover transition-all duration-500 group-hover:scale-102">
            @endif

            <div class="absolute bottom-4 left-1/2 transform -translate-x-1/2 z-10">
                <button @click="bukaModal = true" type="button" class="bg-black/70 hover:bg-black/90 text-white backdrop-blur-sm text-xs px-5 py-2.5 rounded-xl font-medium flex items-center gap-2 transition-all shadow-md cursor-pointer">
                    <i class="fas fa-expand-alt"></i> Lihat Semua Foto
                </button>
            </div>
        </div>

        <div class="grid grid-cols-2 lg:grid-cols-1 gap-3 content-start">
            @foreach([
                ['file' => $project->image, 'label' => 'Utama'],
                ['file' => $project->image_living_room, 'label' => 'Kamar Tidur'],
                ['file' => $project->image_bathroom, 'label' => 'Kamar Mandi'],
                ['file' => $project->image_exterior, 'label' => 'Eksterior']
            ] as $index => $imgData)

                @if($imgData['file'])
                    <button @click="fotoAktif = {{ $index }}" type="button"
                            class="relative h-[110px] w-full bg-slate-100 rounded-xl overflow-hidden border-2 transition-all focus:outline-none cursor-pointer"
                            :class="fotoAktif === {{ $index }} ? 'border-gold-500 ring-2 ring-gold-500/20 shadow-sm' : 'border-slate-200/60 opacity-80 hover:opacity-100'">

                        <img src="{{ $imgData['file'] ? asset('uploads/properties/' . $imgData['file']) : asset('images/no-image.svg') }}"
                             class="w-full h-full object-cover"
                             onerror="this.onerror=null; this.src='{{ asset('images/no-image.svg') }}'">

                        <span class="absolute bottom-2 right-2 bg-black/60 text-[10px] font-medium text-white px-2 py-0.5 rounded-md">
                            {{ $imgData['label'] }}
                        </span>
                    </button>
                @else
                    <div class="h-[110px] w-full bg-slate-50 rounded-xl border border-dashed border-slate-200 flex flex-col items-center justify-center opacity-60">
                        <i class="far fa-image text-slate-300 text-base mb-1"></i>
                        <span class="text-[10px] text-slate-400 italic">No {{ $imgData['label'] }}</span>
                    </div>
                @endif

            @endforeach
        </div>

    </div>

    <div x-show="bukaModal"
         class="fixed inset-0 z-999 bg-black/95 flex items-center justify-center p-4 select-none"
         @keydown.escape.window="bukaModal = false"
         style="display: none;">

        <button @click="bukaModal = false" type="button" class="absolute top-6 right-6 text-white hover:text-red-400 text-3xl transition-all z-1000 cursor-pointer p-2">
            <i class="fas fa-times"></i>
        </button>

        <button @click="fotoAktif = fotoAktif > 0 ? fotoAktif - 1 : 3" type="button" class="absolute left-4 md:left-8 text-white hover:text-gold-400 text-4xl transition-all z-1000 cursor-pointer p-4">
            <i class="fas fa-chevron-left"></i>
        </button>

        <div class="max-w-5xl max-h-[85vh] w-full h-full flex items-center justify-center pointer-events-none">

            <img src="{{ asset('uploads/properties/' . ($project->image ?? $project['image'])) }}"
                 x-show="fotoAktif === 0"
                 alt="Utama"
                 class="max-w-full max-h-full object-contain rounded-xl shadow-2xl">

            <img src="{{ ($project->image_living_room ?? $project['image_living_room']) ? asset('uploads/properties/' . ($project->image_living_room ?? $project['image_living_room'])) : asset('uploads/properties/' . ($project->image ?? $project['image'])) }}"
                 x-show="fotoAktif === 1"
                 alt="Kamar Tidur"
                 class="max-w-full max-h-full object-contain rounded-xl shadow-2xl"
                 onerror="this.onerror=null; this.src='{{ asset('uploads/properties/' . ($project->image ?? $project['image'])) }}';">

            <img src="{{ ($project->image_bathroom ?? $project['image_bathroom']) ? asset('uploads/properties/' . ($project->image_bathroom ?? $project['image_bathroom'])) : asset('uploads/properties/' . ($project->image ?? $project['image'])) }}"
                 x-show="fotoAktif === 2"
                 alt="Kamar Mandi"
                 class="max-w-full max-h-full object-contain rounded-xl shadow-2xl"
                 onerror="this.onerror=null; this.src='{{ asset('uploads/properties/' . ($project->image ?? $project['image'])) }}';">

            <img src="{{ ($project->image_exterior ?? $project['image_exterior']) ? asset('uploads/properties/' . ($project->image_exterior ?? $project['image_exterior'])) : asset('uploads/properties/' . ($project->image ?? $project['image'])) }}"
                 x-show="fotoAktif === 3"
                 alt="Eksterior"
                 class="max-w-full max-h-full object-contain rounded-xl shadow-2xl"
                 onerror="this.onerror=null; this.src='{{ asset('uploads/properties/' . ($project->image ?? $project['image'])) }}';">

        </div>

        <button @click="fotoAktif = fotoAktif < 3 ? fotoAktif + 1 : 0" type="button" class="absolute right-4 md:right-8 text-white hover:text-gold-400 text-4xl transition-all z-1000 cursor-pointer p-4">
            <i class="fas fa-chevron-right"></i>
        </button>

        <div class="absolute bottom-6 text-white/60 text-xs font-mono tracking-widest bg-white/5 px-3 py-1 rounded-full backdrop-blur-sm">
            <span class="text-white font-bold" x-text="fotoAktif + 1"></span> / 4
        </div>
    </div>
</div>

<section class="py-12 bg-white">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="grid lg:grid-cols-3 gap-12">

            <div class="lg:col-span-2">
                <div class="flex items-start justify-between mb-6">
                    <div>
                        <h1 class="font-display text-3xl md:text-4xl font-bold text-gray-900">
                            {{ $project->name ?? $project['name'] }}
                        </h1>
                        <div class="flex items-center text-gray-500 mt-3 text-sm">
                            <i class="fas fa-map-marker-alt text-primary-600 mr-2"></i>
                            <span>{{ $project->location ?? $project['location'] }}</span>
                        </div>
                    </div>
                    @php
    $savedDetail = Auth::check() ? Auth::user()->hasSavedProperty($project->id) : false;
@endphp
                    <div class="flex space-x-2 mt-2">
                        @auth
                        <button onclick="toggleFav({{ $project->id }}, this)" class="w-12 h-12 border border-gray-300 rounded-full flex items-center justify-center transition-colors {{ $savedDetail ? 'text-red-500 border-red-500' : 'text-gray-600 hover:text-red-500 hover:border-red-500' }}">
                            <i class="{{ $savedDetail ? 'fas' : 'far' }} fa-heart"></i>
                        </button>
                        @else
                        <a href="{{ route('login') }}" class="w-12 h-12 border border-gray-300 rounded-full flex items-center justify-center text-gray-600 hover:text-red-500 hover:border-red-500 transition-colors">
                            <i class="far fa-heart"></i>
                        </a>
                        @endauth
                        <button onclick="shareProperty('{{ str_replace("'", "\'", $project->name ?? $project['name']) }}', '{{ url()->current() }}')" class="w-12 h-12 border border-gray-300 rounded-full flex items-center justify-center text-gray-600 hover:text-primary-600 hover:border-primary-600 transition-colors cursor-pointer">
                            <i class="fas fa-share-alt"></i>
                        </button>
                    </div>
                </div>

                <div class="bg-primary-50 rounded-2xl p-6 mb-8">
                    <span class="text-gray-600 text-sm font-medium">Harga Properti</span>
                    <div class="font-display text-3xl md:text-4xl font-bold text-primary-600 mt-1">
                        Rp {{ number_format($project->price ?? $project['price'] ?? 2000000000, 0, ',', '.') }}
                    </div>
                </div>

                <div class="grid grid-cols-2 md:grid-cols-4 gap-6 mb-8">
                    <div class="bg-gray-50 rounded-xl p-4 text-center">
                        <i class="fas fa-bed text-2xl text-primary-600 mb-2"></i>
                        <div class="font-bold text-xl text-gray-900">{{ $project->bedrooms ?? $project['bedrooms'] ?? 3 }}</div>
                        <div class="text-gray-500 text-sm">Kamar Tidur</div>
                    </div>
                    <div class="bg-gray-50 rounded-xl p-4 text-center">
                        <i class="fas fa-bath text-2xl text-primary-600 mb-2"></i>
                        <div class="font-bold text-xl text-gray-900">{{ $project->bathrooms ?? $project['bathrooms'] ?? 2 }}</div>
                        <div class="text-gray-500 text-sm">Kamar Mandi</div>
                    </div>
                    <div class="bg-gray-50 rounded-xl p-4 text-center">
                        <i class="fas fa-ruler-combined text-2xl text-primary-600 mb-2"></i>
                        <div class="font-bold text-xl text-gray-900">{{ $project->building_area ?? $project['area'] ?? 300 }} m²</div>
                        <div class="text-gray-500 text-sm">Luas Bangunan</div>
                    </div>
                    <div class="bg-gray-50 rounded-xl p-4 text-center">
                        <i class="fas fa-vector-square text-2xl text-primary-600 mb-2"></i>
                        <div class="font-bold text-xl text-gray-900">{{ $project->land_area ?? 400 }} m²</div>
                        <div class="text-gray-500 text-sm">Luas Tanah</div>
                    </div>
                </div>

                <div class="mb-8">
                    <h2 class="font-display font-bold text-2xl text-gray-900 mb-4">Deskripsi</h2>
                    <p class="text-gray-600 leading-relaxed">{{ $project->description ?? $project['description'] ?? 'Hunian modern dengan lokasi strategis.' }}</p>
                </div>

                @if(!empty($project->virtual_tour_url))
                <div class="mb-8">
                    <h2 class="font-display font-bold text-2xl text-gray-900 mb-4">Virtual Tour</h2>
                    <div class="relative rounded-2xl overflow-hidden bg-gray-100" style="padding-bottom: 56.25%;">
                        <iframe src="{{ $project->virtual_tour_url }}"
                                class="absolute inset-0 w-full h-full"
                                frameborder="0"
                                allowfullscreen
                                allow="xr-spatial-tracking">
                        </iframe>
                    </div>
                </div>
                @endif

                <div>
                    <h2 class="font-display font-bold text-2xl text-gray-900 mb-4">Lokasi</h2>
                    <div class="rounded-2xl overflow-hidden bg-gray-100 h-[300px]">
                        <iframe src="https://maps.google.com/maps?q={{ urlencode($project->location ?? $project['location']) }}&t=&z=13&ie=UTF8&iwloc=&output=embed"
                                class="w-full h-full"
                                frameborder="0"
                                style="border:0;"
                                allowfullscreen=""
                                loading="lazy">
                        </iframe>
                    </div>
                </div>
            </div>

            <div class="lg:col-span-1">
    @php
        $iplDef = ($project->ipl_cost ?? 0) > 0 ? $project->ipl_cost : 0;
        $taxDef = ($project->tax_cost ?? 0) > 0 ? $project->tax_cost : 0;
        $adminDef = ($project->admin_cost ?? 0) > 0 ? $project->admin_cost : config('payment.admin_fee');
        $bookingFee = config('payment.booking_fee');
    @endphp
    <div x-data="{
        tipeBayar: 'booking',
        cicilan: 'none',
        hargaProperti: {{ $project->price ?? $project['price'] ?? 2000000000 }},
        bookingFee: {{ $bookingFee }},
        iplCost: {{ $iplDef }},
        taxCost: {{ $taxDef }},
        adminCost: {{ $adminDef }},
        get pokok() {
            if (this.tipeBayar === 'booking') return this.bookingFee;
            if (this.tipeBayar === 'dp') return this.hargaProperti * 0.20;
            return this.hargaProperti;
        },
        get ipl() { return this.iplCost > 0 ? this.iplCost : this.pokok * 0.20; },
        get tax() { return this.taxCost > 0 ? this.taxCost : this.pokok * 0.02; },
        get admin() { return this.adminCost > 0 ? this.adminCost : 10000000; },
        get total() { return this.pokok + this.ipl + this.tax + this.admin; },

        get showCicilan() { return this.tipeBayar === 'booking' || this.tipeBayar === 'dp'; },

        // Cicilan rates
        get cicilanMonthly() { return { count: 1, rate: 0, label: '1 Bulan' }; },
        get cicilanQuarterly() { return { count: 3, rate: 0.02, label: '3 Bulan' }; },
        get cicilanSemiAnnual() { return { count: 6, rate: 0.035, label: '6 Bulan' }; },

        get cicilanData() {
            if (this.cicilan === 'none') return null;
            const plans = { monthly: this.cicilanMonthly, quarterly: this.cicilanQuarterly, semi_annually: this.cicilanSemiAnnual };
            const p = plans[this.cicilan] || plans.monthly;
            const totalWithFee = this.total * (1 + p.rate);
            const perInst = Math.ceil(totalWithFee / p.count);
            return { ...p, totalWithFee, perInst, serviceFee: totalWithFee - this.total };
        },

        get displayTotal() {
            if (this.cicilan !== 'none' && this.cicilanData) {
                return this.cicilanData.totalWithFee;
            }
            return this.total;
        },

        get checkoutUrl() {
            let url = '/transaction/checkout/{{ $project->id ?? $project['id'] }}?method=' + this.tipeBayar;
            if (this.cicilan !== 'none' && this.showCicilan) {
                url += '&installment=' + this.cicilan;
            }
            return url;
        }
    }"
         class="bg-white rounded-xl shadow-lg border border-gray-100 sticky top-24">
        <div class="p-6">
            <h3 class="text-xl font-bold text-gray-900 mb-4">Metode Pembayaran</h3>

            <div class="grid grid-cols-3 gap-2 p-1.5 bg-gray-50 rounded-xl mb-4 border border-gray-200/60">
                <button @click="tipeBayar = 'booking'; cicilan = 'none'" type="button"
                        :class="tipeBayar === 'booking' ? 'bg-blue-600 text-white shadow-sm' : 'text-gray-600 hover:text-gray-900'"
                        class="py-2.5 text-xs font-bold rounded-lg transition-all cursor-pointer">
                    Booking
                </button>
                <button @click="tipeBayar = 'dp'; cicilan = 'none'" type="button"
                        :class="tipeBayar === 'dp' ? 'bg-blue-600 text-white shadow-sm' : 'text-gray-600 hover:text-gray-900'"
                        class="py-2.5 text-xs font-bold rounded-lg transition-all cursor-pointer">
                    DP (20%)
                </button>
                <button @click="tipeBayar = 'cash'; cicilan = 'none'" type="button"
                        :class="tipeBayar === 'cash' ? 'bg-blue-600 text-white shadow-sm' : 'text-gray-600 hover:text-gray-900'"
                        class="py-2.5 text-xs font-bold rounded-lg transition-all cursor-pointer">
                    Cash
                </button>
            </div>

            <div x-show="showCicilan" x-cloak class="mb-4">
                <h4 class="text-xs font-bold uppercase tracking-wider text-gray-400 mb-2">Opsi Cicilan</h4>
                <div class="grid grid-cols-4 gap-1.5 p-1 bg-gray-50 rounded-lg border border-gray-200/60">
                    <button @click="cicilan = 'none'" type="button"
                            :class="cicilan === 'none' ? 'bg-green-600 text-white shadow-sm' : 'text-gray-500 hover:text-gray-800'"
                            class="py-2 text-[10px] font-bold rounded-md transition-all cursor-pointer">
                        Full
                    </button>
                    <button @click="cicilan = 'monthly'" type="button"
                            :class="cicilan === 'monthly' ? 'bg-purple-600 text-white shadow-sm' : 'text-gray-500 hover:text-gray-800'"
                            class="py-2 text-[10px] font-bold rounded-md transition-all cursor-pointer">
                        1 Bln
                    </button>
                    <button @click="cicilan = 'quarterly'" type="button"
                            :class="cicilan === 'quarterly' ? 'bg-purple-600 text-white shadow-sm' : 'text-gray-500 hover:text-gray-800'"
                            class="py-2 text-[10px] font-bold rounded-md transition-all cursor-pointer">
                        3 Bln
                    </button>
                    <button @click="cicilan = 'semi_annually'" type="button"
                            :class="cicilan === 'semi_annually' ? 'bg-purple-600 text-white shadow-sm' : 'text-gray-500 hover:text-gray-800'"
                            class="py-2 text-[10px] font-bold rounded-md transition-all cursor-pointer">
                        6 Bln
                    </button>
                </div>
            </div>

            <h4 class="text-xs font-bold uppercase tracking-wider text-gray-400 mb-3">Rincian Komponen</h4>
            <div class="space-y-4 mb-6">

                <div class="flex justify-between text-sm text-gray-600">
                    <span x-show="tipeBayar === 'booking'">Biaya Booking Fixed</span>
                    <span x-show="tipeBayar === 'dp'">Nilai DP (20%)</span>
                    <span x-show="tipeBayar === 'cash'">Harga Properti Lunas</span>
                    <span class="font-semibold text-gray-800">Rp <span x-text="pokok.toLocaleString('id-ID')"></span></span>
                </div>

                <div class="flex justify-between text-sm text-gray-600">
                    <span>IPL <span x-text="iplCost > 0 ? '(Fixed)' : '(20% dari Pokok)'"></span></span>
                    <span class="font-medium text-gray-900">Rp <span x-text="ipl.toLocaleString('id-ID')"></span></span>
                </div>

                <hr class="border-gray-100">

                <div class="flex justify-between text-sm text-gray-600">
                    <span>Pajak (PPN) <span x-text="taxCost > 0 ? '(Fixed)' : '(2% dari Pokok)'"></span></span>
                    <span class="font-medium text-gray-900">Rp <span x-text="tax.toLocaleString('id-ID')"></span></span>
                </div>

                <div class="flex justify-between text-sm text-gray-600">
                    <span>Biaya Admin</span>
                    <span class="font-medium text-gray-900">Rp <span x-text="admin.toLocaleString('id-ID')"></span></span>
                </div>

                <template x-if="cicilan !== 'none' && cicilanData">
                    <div class="bg-purple-50 p-3 rounded-xl border border-purple-100">
                        <div class="flex justify-between items-center text-purple-800 text-xs mb-2">
                            <span class="font-bold">Rencana Cicilan (<span x-text="cicilanData.count"></span>x)</span>
                            <span>Biaya Jasa: Rp <span x-text="Math.round(cicilanData.serviceFee).toLocaleString('id-ID')"></span></span>
                        </div>
                        <div class="flex justify-between items-center text-purple-800">
                            <span class="text-xs font-bold">Per Cicilan</span>
                            <span class="text-lg font-black">Rp <span x-text="Math.round(cicilanData.perInst).toLocaleString('id-ID')"></span></span>
                        </div>
                    </div>
                </template>

                <div class="bg-blue-50 p-4 rounded-xl border border-blue-100 mt-4">
                    <div class="flex justify-between items-center text-blue-800">
                        <span class="text-xs font-bold uppercase tracking-wider">
                            <template x-if="cicilan !== 'none' && showCicilan">Total + Jasa</template>
                            <template x-if="cicilan === 'none' || !showCicilan">Total Pembayaran</template>
                        </span>
                        <span class="text-xl font-black">Rp <span x-text="Math.round(displayTotal).toLocaleString('id-ID')"></span></span>
                    </div>
                </div>
            </div>

            <div class="space-y-3">
                @if($isSold)
                <div class="w-full bg-red-50 border border-red-200 text-red-600 font-bold py-4 rounded-xl flex items-center justify-center text-sm">
                    <i class="fas fa-times-circle mr-2"></i> Unit ini sudah terjual
                </div>
                @else
                <a :href="checkoutUrl"
                   class="w-full bg-blue-600 hover:bg-blue-700 text-white font-bold py-4 rounded-xl transition-all shadow-lg shadow-blue-200 flex items-center justify-center text-sm">
                    <i class="fas fa-money-check-alt mr-2"></i> Lanjutkan Pembayaran
                </a>
                @endif

                <button onclick="document.getElementById('modalJadwal').classList.remove('hidden')" type="button"
                        class="w-full bg-white border-2 border-gray-200 text-gray-600 hover:bg-gray-50 font-bold py-3 rounded-xl transition-all flex items-center justify-center text-sm cursor-pointer">
                    <i class="fas fa-calendar-alt mr-2"></i> Jadwalkan Kunjungan
                </button>
            </div>

            <div class="mt-4 flex items-center justify-center space-x-2 text-xs text-gray-400">
                <i class="fas fa-shield-alt"></i>
                <span>Pembayaran Terenkripsi & Aman</span>
            </div>
        </div>
    </div>
</div>

<div id="modalJadwal" onclick="if(event.target===this)this.classList.add('hidden')" class="hidden fixed inset-0 z-[999] bg-black/60 flex items-center justify-center p-4">
    <div class="bg-white rounded-2xl max-w-lg w-full p-6 shadow-2xl relative">
        <button onclick="document.getElementById('modalJadwal').classList.add('hidden')" type="button" class="absolute top-4 right-4 text-gray-400 hover:text-gray-600 text-2xl cursor-pointer">
            <i class="fas fa-times"></i>
        </button>

        <div class="mb-6">
            <h3 class="font-display font-bold text-xl text-gray-900">Jadwalkan Kunjungan</h3>
            <p class="text-sm text-gray-500 mt-1">Isi form berikut untuk mengajukan survei properti.</p>
        </div>

        @auth
        <form method="POST" action="{{ route('visit-schedule.store') }}">
            @csrf
            <input type="hidden" name="property_id" value="{{ $project->id ?? $project['id'] }}">

            <div class="space-y-4">
                <div>
                    <label class="block text-sm font-semibold text-gray-700 mb-1.5">Tanggal Kunjungan</label>
                    <input type="date" name="visit_date"
                           min="{{ date('Y-m-d') }}"
                           class="w-full px-4 py-3 rounded-xl border border-gray-200 focus:ring-2 focus:ring-blue-500 focus:border-transparent"
                           required>
                </div>
                <div>
                    <label class="block text-sm font-semibold text-gray-700 mb-1.5">Waktu Kunjungan</label>
                    <input type="time" name="visit_time"
                           class="w-full px-4 py-3 rounded-xl border border-gray-200 focus:ring-2 focus:ring-blue-500 focus:border-transparent"
                           required>
                </div>
                <div>
                    <label class="block text-sm font-semibold text-gray-700 mb-1.5">Catatan (opsional)</label>
                    <textarea name="notes" rows="3"
                              class="w-full px-4 py-3 rounded-xl border border-gray-200 focus:ring-2 focus:ring-blue-500 focus:border-transparent resize-none"
                              placeholder="Contoh: ingin survei bersama keluarga"></textarea>
                </div>
            </div>

            <div class="mt-6 flex gap-3">
                <button type="button" onclick="document.getElementById('modalJadwal').classList.add('hidden')"
                        class="flex-1 bg-gray-100 hover:bg-gray-200 text-gray-700 font-bold py-3 rounded-xl transition-all cursor-pointer">
                    Batal
                </button>
                <button type="submit"
                        class="flex-1 bg-blue-600 hover:bg-blue-700 text-white font-bold py-3 rounded-xl transition-all shadow-lg">
                    <i class="fas fa-paper-plane mr-2"></i> Ajukan Kunjungan
                </button>
            </div>
        </form>
        @else
        <div class="text-center py-6">
            <p class="text-gray-600 mb-4">Silakan login terlebih dahulu untuk menjadwalkan kunjungan.</p>
            <a href="{{ route('login') }}" class="inline-block bg-blue-600 text-white px-6 py-3 rounded-xl font-bold hover:bg-blue-700 transition">
                <i class="fas fa-sign-in-alt mr-2"></i> Login
            </a>
        </div>
        @endauth
    </div>
</div>

        </div>
    </div>
</section>
@push('scripts')
<script>
document.addEventListener('keydown', function(e) {
    if (e.key === 'Escape') {
        var el = document.getElementById('modalJadwal');
        if (el && !el.classList.contains('hidden')) el.classList.add('hidden');
    }
});

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
            btn.classList.add('text-red-500', 'border-red-500');
            btn.classList.remove('text-gray-600');
        } else {
            icon.className = 'far fa-heart';
            btn.classList.remove('text-red-500', 'border-red-500');
            btn.classList.add('text-gray-600');
        }
    });
}

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
