<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'Dashboard') - White House Premiere</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
    <script defer src="https://unpkg.com/alpinejs@3.x.x/dist/cdn.min.js"></script>
    @stack('head')
</head>
<body class="bg-gray-100 font-sans text-base">

    <div class="flex min-h-screen" x-data="{ sidebarOpen: false }">

        {{-- Mobile overlay --}}
        <div x-show="sidebarOpen" x-transition:enter="transition ease-out duration-200" x-transition:enter-start="opacity-0" x-transition:enter-end="opacity-100" x-transition:leave="transition ease-in duration-150" x-transition:leave-start="opacity-100" x-transition:leave-end="opacity-0" x-cloak class="fixed inset-0 bg-black/50 z-30 lg:hidden" @click="sidebarOpen = false"></div>

        {{-- Sidebar toggle button (mobile) --}}
        <button @click="sidebarOpen = !sidebarOpen" class="fixed top-4 left-4 z-50 lg:hidden bg-slate-900 text-white p-2.5 rounded-lg shadow-lg hover:bg-slate-800 transition-colors">
            <i class="fas fa-bars text-lg"></i>
        </button>

        {{-- Sidebar --}}
        <div :class="sidebarOpen ? 'translate-x-0' : '-translate-x-full'" class="fixed inset-y-0 left-0 z-40 transition-transform duration-300 lg:translate-x-0 lg:static lg:z-auto">
            @include('partials.admin-sidebar')
        </div>

        {{-- Main Content --}}
        <main class="flex-1 lg:ml-64 p-4 lg:p-8 pt-16 lg:pt-8 min-h-screen transition-all duration-300">
            {{-- Header --}}
            <header class="flex justify-between items-center mb-6 lg:mb-8 bg-white p-4 rounded-xl shadow-sm border border-gray-100">
                <div>
                    <h2 class="text-lg lg:text-xl font-bold text-slate-800">@yield('title', 'Dashboard')</h2>
                    <p class="text-xs lg:text-sm text-slate-500 mt-0.5">@yield('subtitle', 'Kelola data properti White House Premiere.')</p>
                </div>
                <div class="flex items-center gap-3 lg:gap-4">
                    <a href="{{ route('home') }}" target="_blank" class="text-slate-400 hover:text-blue-600 transition-colors" title="Lihat Website">
                        <i class="fas fa-external-link-alt text-sm lg:text-base"></i>
                    </a>
                    <a href="{{ route('profile') }}" class="text-slate-400 hover:text-blue-600 transition-colors" title="Profil Saya">
                        <i class="fas fa-user-cog text-sm lg:text-base"></i>
                    </a>
                    <button class="text-slate-400 hover:text-blue-600 transition-colors relative" title="Notifikasi">
                        <i class="fas fa-bell text-sm lg:text-base"></i>
                    </button>
                    <div class="h-8 w-8 lg:h-9 lg:w-9 bg-blue-100 rounded-full flex items-center justify-center text-blue-600 font-bold text-xs lg:text-sm">
                        {{ Auth::user()->initials }}
                    </div>
                    <span class="text-sm text-slate-600 font-medium hidden md:block">{{ Auth::user()->name }}</span>
                </div>
            </header>

            {{-- Content --}}
            @yield('content')
        </main>
    </div>

    <style>
        [x-cloak] { display: none !important; }
        .line-clamp-2 { display: -webkit-box; -webkit-line-clamp: 2; -webkit-box-orient: vertical; overflow: hidden; }
    </style>
    @stack('scripts')
</body>
</html>
