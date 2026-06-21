<aside class="w-64 bg-slate-900 text-white fixed h-full transition-all duration-300 z-40 overflow-y-auto">
    <div class="p-6 text-center border-b border-slate-800">
        <a href="{{ url('/') }}" class="block group transition duration-200 hover:opacity-80">
            <h1 class="text-xl font-bold tracking-widest text-blue-400 group-hover:text-blue-300 transition-colors">
                WH PREMIERE
            </h1>
            <p class="text-xs text-slate-500 uppercase mt-1 tracking-wider">Admin Panel</p>
        </a>
    </div>

    <nav class="mt-4 px-3 space-y-1">

        <a href="{{ route('admin.dashboard') }}"
           class="flex items-center gap-3 px-4 py-2.5 rounded-lg text-sm font-medium transition-all duration-200 {{ request()->routeIs('admin.dashboard') ? 'bg-blue-600 text-white shadow-lg shadow-blue-600/20' : 'text-slate-400 hover:bg-slate-800 hover:text-white' }}">
            <i class="fas fa-chart-pie w-5 text-center text-base"></i>
            <span>Dashboard</span>
        </a>

        <div class="pt-4 pb-1 px-1 text-[11px] font-semibold text-slate-600 uppercase tracking-widest">Produk</div>

        <div x-data="{ open: {{ request()->routeIs('admin.properties.*') || request()->routeIs('admin.categories.*') ? 'true' : 'false' }} }">
            <button @click="open = !open"
                    class="w-full flex items-center gap-3 px-4 py-2.5 rounded-lg text-sm font-medium transition-all duration-200 {{ request()->routeIs('admin.properties.*') || request()->routeIs('admin.categories.*') ? 'bg-slate-800 text-white' : 'text-slate-400 hover:bg-slate-800 hover:text-white' }}">
                <i class="fas fa-city w-5 text-center text-base"></i>
                <span class="flex-1 text-left">Manajemen Unit</span>
                <i class="fas fa-chevron-down text-[10px] transition-transform duration-300" :class="{ 'rotate-180': open }"></i>
            </button>

            <div x-show="open" x-transition:enter="transition ease-out duration-200" x-transition:enter-start="opacity-0 -translate-y-2" x-transition:enter-end="opacity-100 translate-y-0" x-cloak class="mt-1 space-y-0.5 ml-2 pl-3 border-l border-slate-700/50">
                <a href="{{ route('admin.properties.index') }}"
                   class="flex items-center gap-3 px-4 py-2 rounded-lg text-sm transition-all duration-200 {{ request()->routeIs('admin.properties.*') ? 'bg-blue-600/10 text-blue-400 font-semibold' : 'text-slate-400 hover:bg-slate-800 hover:text-slate-200' }}">
                    <i class="fas fa-list-ul w-4 text-center text-xs"></i>
                    Daftar Unit
                </a>
                <a href="{{ route('admin.categories.index') }}"
                   class="flex items-center gap-3 px-4 py-2 rounded-lg text-sm transition-all duration-200 {{ request()->routeIs('admin.categories.*') ? 'bg-blue-600/10 text-blue-400 font-semibold' : 'text-slate-400 hover:bg-slate-800 hover:text-slate-200' }}">
                    <i class="fas fa-th-large w-4 text-center text-xs"></i>
                    Tipe & Kategori
                </a>
            </div>
        </div>

        <div class="pt-4 pb-1 px-1 text-[11px] font-semibold text-slate-600 uppercase tracking-widest">Bisnis</div>

        <div x-data="{ open: {{ request()->routeIs('admin.transaction.*') || request()->routeIs('admin.chat.*') || request()->routeIs('admin.inquiries.*') || request()->routeIs('admin.testimonials.*') || request()->routeIs('admin.visit-schedules.*') || request()->routeIs('admin.facilities.*') || request()->routeIs('admin.manajemenuser.*') || request()->routeIs('admin.laporan-admin.*') ? 'true' : 'false' }} }">
            <button @click="open = !open"
                    class="w-full flex items-center gap-3 px-4 py-2.5 rounded-lg text-sm font-medium transition-all duration-200 {{ request()->routeIs('admin.transaction.*') || request()->routeIs('admin.chat.*') || request()->routeIs('admin.inquiries.*') || request()->routeIs('admin.testimonials.*') || request()->routeIs('admin.visit-schedules.*') || request()->routeIs('admin.facilities.*') || request()->routeIs('admin.manajemenuser.*') || request()->routeIs('admin.laporan-admin.*') ? 'bg-slate-800 text-white' : 'text-slate-400 hover:bg-slate-800 hover:text-white' }}">
                <i class="fas fa-hand-holding-usd w-5 text-center text-base"></i>
                <span class="flex-1 text-left">Sales & Users</span>
                <i class="fas fa-chevron-down text-[10px] transition-transform duration-300" :class="{ 'rotate-180': open }"></i>
            </button>

            <div x-show="open" x-transition:enter="transition ease-out duration-200" x-transition:enter-start="opacity-0 -translate-y-2" x-transition:enter-end="opacity-100 translate-y-0" x-cloak class="mt-1 space-y-0.5 ml-2 pl-3 border-l border-slate-700/50">
                <a href="{{ route('admin.transaction.index') }}"
                   class="flex items-center gap-3 px-4 py-2 rounded-lg text-sm transition-all duration-200 {{ request()->routeIs('admin.transaction.*') ? 'bg-blue-600/10 text-blue-400 font-semibold' : 'text-slate-400 hover:bg-slate-800 hover:text-slate-200' }}">
                    <i class="fas fa-exchange-alt w-4 text-center text-xs"></i>
                    Transaksi
                </a>
                <a href="{{ route('admin.chat.index') }}"
                   class="flex items-center gap-3 px-4 py-2 rounded-lg text-sm transition-all duration-200 {{ request()->routeIs('admin.chat.*') ? 'bg-blue-600/10 text-blue-400 font-semibold' : 'text-slate-400 hover:bg-slate-800 hover:text-slate-200' }}">
                    <i class="fas fa-comments w-4 text-center text-xs"></i>
                    Chat
                </a>
                <a href="{{ route('admin.inquiries.index') }}"
                   class="flex items-center gap-3 px-4 py-2 rounded-lg text-sm transition-all duration-200 {{ request()->routeIs('admin.inquiries.*') ? 'bg-blue-600/10 text-blue-400 font-semibold' : 'text-slate-400 hover:bg-slate-800 hover:text-slate-200' }}">
                    <i class="fas fa-question-circle w-4 text-center text-xs"></i>
                    Inquiries
                </a>
                <a href="{{ route('admin.testimonials.index') }}"
                   class="flex items-center gap-3 px-4 py-2 rounded-lg text-sm transition-all duration-200 {{ request()->routeIs('admin.testimonials.*') ? 'bg-blue-600/10 text-blue-400 font-semibold' : 'text-slate-400 hover:bg-slate-800 hover:text-slate-200' }}">
                    <i class="fas fa-star w-4 text-center text-xs"></i>
                    Testimoni
                </a>
                <a href="{{ route('admin.visit-schedules.index') }}"
                   class="flex items-center gap-3 px-4 py-2 rounded-lg text-sm transition-all duration-200 {{ request()->routeIs('admin.visit-schedules.*') ? 'bg-blue-600/10 text-blue-400 font-semibold' : 'text-slate-400 hover:bg-slate-800 hover:text-slate-200' }}">
                    <i class="fas fa-calendar-check w-4 text-center text-xs"></i>
                    Jadwal Kunjungan
                    @php $pendingVisits = \App\Models\VisitSchedule::where('status', 'pending')->count(); @endphp
                    @if($pendingVisits > 0)
                        <span class="bg-red-500 text-white text-[10px] font-bold px-1.5 py-0.5 rounded-full ml-auto">{{ $pendingVisits }}</span>
                    @endif
                </a>
                <a href="{{ route('admin.facilities.index') }}"
                   class="flex items-center gap-3 px-4 py-2 rounded-lg text-sm transition-all duration-200 {{ request()->routeIs('admin.facilities.*') ? 'bg-blue-600/10 text-blue-400 font-semibold' : 'text-slate-400 hover:bg-slate-800 hover:text-slate-200' }}">
                    <i class="fas fa-list-check w-4 text-center text-xs"></i>
                    Fasilitas
                </a>
                <a href="{{ route('admin.manajemenuser.index') }}"
                   class="flex items-center gap-3 px-4 py-2 rounded-lg text-sm transition-all duration-200 {{ request()->routeIs('admin.manajemenuser.*') ? 'bg-blue-600/10 text-blue-400 font-semibold' : 'text-slate-400 hover:bg-slate-800 hover:text-slate-200' }}">
                    <i class="fas fa-user-friends w-4 text-center text-xs"></i>
                    Manajemen Users
                </a>
                <a href="{{ route('admin.laporan-admin.index') }}"
                   class="flex items-center gap-3 px-4 py-2 rounded-lg text-sm transition-all duration-200 {{ request()->routeIs('admin.laporan-admin.*') ? 'bg-blue-600/10 text-blue-400 font-semibold' : 'text-slate-400 hover:bg-slate-800 hover:text-slate-200' }}">
                    <i class="fas fa-clipboard-list w-4 text-center text-xs"></i>
                    Laporan Admin
                </a>
            </div>
        </div>

    </nav>

    <div class="absolute bottom-0 left-0 right-0 p-3 border-t border-slate-800 bg-slate-900">
        <a href="#" onclick="event.preventDefault(); document.getElementById('logout-form-sidebar').submit();"
           class="flex items-center gap-3 px-4 py-2.5 rounded-lg text-sm font-medium text-red-400 hover:text-red-300 hover:bg-red-500/10 transition-all duration-200">
            <i class="fas fa-sign-out-alt w-5 text-center text-base"></i>
            <span>Logout</span>
        </a>
        <form id="logout-form-sidebar" action="{{ route('logout') }}" method="POST" class="hidden">
            @csrf
        </form>
    </div>
</aside>
