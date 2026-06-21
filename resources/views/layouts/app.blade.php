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
</body>
</html>
