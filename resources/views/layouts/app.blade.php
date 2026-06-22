<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="description" content="White House Premiere - Properti Premium Terpercaya di Indonesia">
    <title>@yield('title', 'White House Premiere - Properti Premium')</title>
    
    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Playfair+Display:wght@400;500;600;700&family=Inter:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    
    <!-- Tailwind CSS CDN -->
    <script src="https://cdn.tailwindcss.com"></script>
    <script>
        tailwind.config = {
            theme: {
                extend: {
                    colors: {
                        primary: {
                            50: '#eff6ff',
                            100: '#dbeafe',
                            200: '#bfdbfe',
                            300: '#93c5fd',
                            400: '#60a5fa',
                            500: '#3b82f6',
                            600: '#1e40af',
                            700: '#1e3a8a',
                            800: '#1e3a8a',
                            900: '#172554',
                        },
                        gold: {
                            50: '#fffbeb',
                            100: '#fef3c7',
                            200: '#fde68a',
                            300: '#fcd34d',
                            400: '#fbbf24',
                            500: '#d4a84b',
                            600: '#b8942f',
                            700: '#92751a',
                            800: '#78611b',
                            900: '#654f1c',
                        }
                    },
                    fontFamily: {
                        'display': ['Playfair Display', 'serif'],
                        'sans': ['Inter', 'sans-serif'],
                    }
                }
            }
        }
    </script>
    
    <!-- Alpine.js -->
    <script defer src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js"></script>
    
    <!-- Font Awesome -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    
    <style>
        [x-cloak] { display: none !important; }
        html { font-size: 16px; scroll-behavior: smooth; }
        @media (min-width: 768px) { html { font-size: 17px; } }
    </style>
    
    @stack('styles')
</head>
<body class="font-sans antialiased bg-white text-gray-800">
    <!-- Navbar -->
    @include('partials.navbar')
    
    <!-- Main Content -->
    <main>
        @yield('content')
    </main>
    
    <!-- Footer -->
    @include('partials.footer')
    
    @stack('scripts')

    @unless(request()->is('admin/*') || request()->is('chat*') || request()->is('login*') || request()->is('register*'))
    <div class="fixed bottom-6 right-6 z-50 group">
        <a href="{{ url('/chat') }}"
           class="flex items-center justify-center w-14 h-14 bg-primary-600 hover:bg-primary-700 text-white rounded-full shadow-lg shadow-primary-200 hover:shadow-xl hover:scale-105 active:scale-95 transition-all duration-200"
           title="Chat dengan Kami">
            <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                <path stroke-linecap="round" stroke-linejoin="round" d="M8 12h.01M12 12h.01M16 12h.01M21 12c0 4.418-4.03 8-9 8a9.863 9.863 0 01-4.255-.949L3 20l1.395-3.72C3.512 15.042 3 13.574 3 12c0-4.418 4.03-8 9-8s9 3.582 9 8z"/>
            </svg>
        </a>
        <span class="absolute -top-10 left-1/2 -translate-x-1/2 bg-gray-900 text-white text-xs font-medium px-3 py-1.5 rounded-lg opacity-0 group-hover:opacity-100 transition-opacity duration-200 whitespace-nowrap shadow-md pointer-events-none">
            Chat dengan Kami
        </span>
        <span class="absolute inset-0 w-14 h-14 bg-primary-600 rounded-full animate-ping opacity-20 pointer-events-none"></span>
    </div>
    @endunless
</body>
</html>
