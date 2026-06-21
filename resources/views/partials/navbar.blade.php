<nav x-data="{ open: false, scrolled: false, userMenu: false }" 
     x-init="window.addEventListener('scroll', () => { scrolled = window.scrollY > 50 })"
     :class="{ 'bg-white shadow-lg': scrolled, 'bg-transparent': !scrolled }"
     class="fixed top-0 left-0 right-0 z-50 transition-all duration-300">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="flex justify-between items-center h-20">
            <!-- Logo -->
            <a href="{{ route('home') }}" class="flex items-center space-x-3">
                <div class="w-12 h-12 bg-gradient-to-br from-blue-600 to-blue-800 rounded-lg flex items-center justify-center">
                    <i class="fas fa-crown text-gold text-xl"></i>
                </div>
                <div>
                    <span class="font-bold text-xl" :class="{ 'text-gray-800': scrolled, 'text-white': !scrolled }">White House</span>
                    <span class="block text-gold text-sm font-medium -mt-1">Premiere</span>
                </div>
            </a>
            
            <!-- Desktop Menu -->
            <div class="hidden lg:flex items-center space-x-8">
                <a href="{{ route('home') }}" 
                   class="font-medium transition-colors hover:text-gold {{ request()->routeIs('home') ? 'text-gold' : '' }}"
                   :class="{ 'text-gray-700': scrolled && !{{ request()->routeIs('home') ? 'true' : 'false' }}, 'text-white': !scrolled && !{{ request()->routeIs('home') ? 'true' : 'false' }} }">
                    Home
                </a>
                <a href="{{ route('project') }}" 
                   class="font-medium transition-colors hover:text-gold {{ request()->routeIs('project*') ? 'text-gold' : '' }}"
                   :class="{ 'text-gray-700': scrolled && !{{ request()->routeIs('project*') ? 'true' : 'false' }}, 'text-white': !scrolled && !{{ request()->routeIs('project*') ? 'true' : 'false' }} }">
                    Project
                </a>
                <a href="{{ route('testimoni') }}" 
                   class="font-medium transition-colors hover:text-gold {{ request()->routeIs('testimoni') ? 'text-gold' : '' }}"
                   :class="{ 'text-gray-700': scrolled && !{{ request()->routeIs('testimoni') ? 'true' : 'false' }}, 'text-white': !scrolled && !{{ request()->routeIs('testimoni') ? 'true' : 'false' }} }">
                    Testimoni & Review
                </a>
                <a href="{{ route('contact') }}" 
                   class="font-medium transition-colors hover:text-gold {{ request()->routeIs('contact') ? 'text-gold' : '' }}"
                   :class="{ 'text-gray-700': scrolled && !{{ request()->routeIs('contact') ? 'true' : 'false' }}, 'text-white': !scrolled && !{{ request()->routeIs('contact') ? 'true' : 'false' }} }">
                    Contact
                </a>

                <!-- Auth Buttons -->
                @auth
                    <!-- User Dropdown -->
                    <div class="relative" @click.away="userMenu = false">
                        <button @click="userMenu = !userMenu" class="flex items-center space-x-2 bg-blue-600 hover:bg-blue-700 text-white px-4 py-2 rounded-full transition-colors">
                            <div class="w-8 h-8 bg-gold rounded-full flex items-center justify-center text-blue-900 font-bold text-sm">
                                {{ Auth::user()->initials }}
                            </div>
                            <span class="font-medium">{{ Str::words(Auth::user()->name, 1, '') }}</span>
                            <i class="fas fa-chevron-down text-xs"></i>
                        </button>
                        
                        <!-- Dropdown Menu -->
                        <div x-show="userMenu" 
                             x-cloak
                             x-transition:enter="transition ease-out duration-100"
                             x-transition:enter-start="transform opacity-0 scale-95"
                             x-transition:enter-end="transform opacity-100 scale-100"
                             x-transition:leave="transition ease-in duration-75"
                             x-transition:leave-start="transform opacity-100 scale-100"
                             x-transition:leave-end="transform opacity-0 scale-95"
                             class="absolute right-0 mt-2 w-48 bg-white rounded-xl shadow-lg py-2 z-50">
                            <a href="{{ route('dashboard') }}" class="flex items-center px-4 py-2 text-gray-700 hover:bg-gray-100">
                                <i class="fas fa-tachometer-alt w-5 mr-2"></i>
                                Dashboard
                            </a>
                            <a href="{{ route('profile') }}" class="flex items-center px-4 py-2 text-gray-700 hover:bg-gray-100">
                                <i class="fas fa-user w-5 mr-2"></i>
                                Profil Saya
                            </a>
                            <a href="{{ route('saved.properties') }}" class="flex items-center px-4 py-2 text-gray-700 hover:bg-gray-100">
                                <i class="fas fa-heart w-5 mr-2 text-red-400"></i>
                                Properti Tersimpan
                            </a>
                            <a href="{{ route('visit-schedule.index') }}" class="flex items-center px-4 py-2 text-gray-700 hover:bg-gray-100">
                                <i class="fas fa-calendar-check w-5 mr-2 text-green-500"></i>
                                Jadwal Kunjungan
                            </a>
                            <hr class="my-2">
                            <form action="{{ route('logout') }}" method="POST">
                                @csrf
                                <button type="submit" class="flex items-center w-full px-4 py-2 text-red-600 hover:bg-red-50">
                                    <i class="fas fa-sign-out-alt w-5 mr-2"></i>
                                    Logout
                                </button>
                            </form>
                        </div>
                    </div>
                @else
                    <a href="{{ route('login') }}" 
                       class="font-medium transition-colors hover:text-gold"
                       :class="{ 'text-gray-700': scrolled, 'text-white': !scrolled }">
                        <i class="fas fa-sign-in-alt mr-1"></i>
                        Login
                    </a>
                    <a href="{{ route('register') }}" 
                       class="bg-gold hover:bg-yellow-500 text-blue-900 px-6 py-2.5 rounded-full font-semibold transition-all transform hover:scale-105 shadow-lg">
                        Daftar
                    </a>
                @endauth
            </div>
            
            <!-- Mobile Menu Button -->
            <button @click="open = !open" class="lg:hidden p-2">
                <svg class="w-6 h-6" :class="{ 'text-gray-800': scrolled, 'text-white': !scrolled }" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path x-show="!open" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16"/>
                    <path x-show="open" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/>
                </svg>
            </button>
        </div>
    </div>
    
    <!-- Mobile Menu -->
    <div x-show="open" 
         x-cloak
         x-transition:enter="transition ease-out duration-200"
         x-transition:enter-start="opacity-0 -translate-y-4"
         x-transition:enter-end="opacity-100 translate-y-0"
         x-transition:leave="transition ease-in duration-150"
         x-transition:leave-start="opacity-100 translate-y-0"
         x-transition:leave-end="opacity-0 -translate-y-4"
         class="lg:hidden bg-white shadow-xl">
        <div class="px-4 py-6 space-y-4">
            <a href="{{ route('home') }}" class="block py-2 font-medium text-gray-700 hover:text-gold {{ request()->routeIs('home') ? 'text-gold' : '' }}">Home</a>
            <a href="{{ route('project') }}" class="block py-2 font-medium text-gray-700 hover:text-gold {{ request()->routeIs('project*') ? 'text-gold' : '' }}">Project</a>
            <a href="{{ route('testimoni') }}" class="block py-2 font-medium text-gray-700 hover:text-gold {{ request()->routeIs('testimoni') ? 'text-gold' : '' }}">Testimoni & Review</a>
            <a href="{{ route('contact') }}" class="block py-2 font-medium text-gray-700 hover:text-gold {{ request()->routeIs('contact') ? 'text-gold' : '' }}">Contact</a>
            
            <hr class="my-4">
            
            @auth
                <div class="flex items-center space-x-3 py-2">
                    <div class="w-10 h-10 bg-gold rounded-full flex items-center justify-center text-blue-900 font-bold">
                        {{ Auth::user()->initials }}
                    </div>
                    <div>
                        <p class="font-medium text-gray-900">{{ Auth::user()->name }}</p>
                        <p class="text-sm text-gray-500">{{ Auth::user()->email }}</p>
                    </div>
                </div>
                <a href="{{ route('dashboard') }}" class="block py-2 font-medium text-gray-700 hover:text-blue-600">
                    <i class="fas fa-tachometer-alt mr-2"></i>Dashboard
                </a>
                <a href="{{ route('profile') }}" class="block py-2 font-medium text-gray-700 hover:text-blue-600">
                    <i class="fas fa-user mr-2"></i>Profil Saya
                </a>
                <a href="{{ route('saved.properties') }}" class="block py-2 font-medium text-gray-700 hover:text-blue-600">
                    <i class="fas fa-heart mr-2 text-red-400"></i>Properti Tersimpan
                </a>
                <a href="{{ route('visit-schedule.index') }}" class="block py-2 font-medium text-gray-700 hover:text-blue-600">
                    <i class="fas fa-calendar-check mr-2 text-green-500"></i>Jadwal Kunjungan
                </a>
                <form action="{{ route('logout') }}" method="POST" class="mt-2">
                    @csrf
                    <button type="submit" class="block w-full bg-red-500 hover:bg-red-600 text-white px-6 py-3 rounded-full font-semibold text-center">
                        <i class="fas fa-sign-out-alt mr-2"></i>Logout
                    </button>
                </form>
            @else
                <a href="{{ route('login') }}" class="block bg-blue-600 hover:bg-blue-700 text-white px-6 py-3 rounded-full font-semibold text-center">
                    <i class="fas fa-sign-in-alt mr-2"></i>Login
                </a>
                <a href="{{ route('register') }}" class="block bg-gold hover:bg-yellow-500 text-blue-900 px-6 py-3 rounded-full font-semibold text-center mt-3">
                    Daftar Sekarang
                </a>
            @endauth
        </div>
    </div>
</nav>
