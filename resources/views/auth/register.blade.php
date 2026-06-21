@extends('layouts.app')

@section('title', 'Daftar - White House Premiere')

@section('content')
<div class="min-h-screen flex items-center justify-center bg-gradient-to-br from-gray-50 to-blue-50 py-12 px-4 sm:px-6 lg:px-8">
    <div class="max-w-md w-full">
        <!-- Logo -->
        <div class="text-center mb-8">
            <a href="{{ route('home') }}" class="inline-flex items-center space-x-2">
                <div class="w-12 h-12 bg-gradient-to-r from-blue-600 to-blue-800 rounded-lg flex items-center justify-center">
                    <i class="fas fa-crown text-gold text-xl"></i>
                </div>
                <span class="text-2xl font-bold">
                    <span class="text-blue-800">White House</span>
                    <span class="text-gold">Premiere</span>
                </span>
            </a>
            <h2 class="mt-6 text-3xl font-bold text-gray-900">Buat Akun Baru</h2>
            <p class="mt-2 text-gray-600">Bergabung untuk menemukan properti impian Anda</p>
        </div>

        <!-- Register Form Card -->
        <div class="bg-white rounded-2xl shadow-xl p-8">
            <!-- Alert Messages -->
            @if($errors->any())
            <div class="mb-6 p-4 bg-red-50 border border-red-200 rounded-lg">
                <div class="flex items-start space-x-3">
                    <i class="fas fa-exclamation-circle text-red-500 mt-0.5"></i>
                    <div>
                        <p class="text-red-700 font-medium">Terjadi kesalahan:</p>
                        <ul class="mt-1 text-red-600 text-sm list-disc list-inside">
                            @foreach($errors->all() as $error)
                            <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                    </div>
                </div>
            </div>
            @endif

            <form method="POST" action="{{ route('register') }}" class="space-y-5">
                @csrf

                <!-- Name -->
                <div>
                    <label for="name" class="block text-sm font-medium text-gray-700 mb-2">
                        Nama Lengkap
                    </label>
                    <div class="relative">
                        <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                            <i class="fas fa-user text-gray-400"></i>
                        </div>
                        <input 
                            type="text" 
                            id="name" 
                            name="name" 
                            value="{{ old('name') }}"
                            required 
                            autofocus
                            class="block w-full pl-10 pr-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition-colors @error('name') border-red-500 @enderror"
                            placeholder="Masukkan nama lengkap"
                        >
                    </div>
                </div>

                <!-- Email -->
                <div>
                    <label for="email" class="block text-sm font-medium text-gray-700 mb-2">
                        Email Address
                    </label>
                    <div class="relative">
                        <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                            <i class="fas fa-envelope text-gray-400"></i>
                        </div>
                        <input 
                            type="email" 
                            id="email" 
                            name="email" 
                            value="{{ old('email') }}"
                            required 
                            class="block w-full pl-10 pr-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition-colors @error('email') border-red-500 @enderror"
                            placeholder="nama@email.com"
                        >
                    </div>
                </div>

                <!-- Phone -->
                <div>
                    <label for="phone" class="block text-sm font-medium text-gray-700 mb-2">
                        Nomor Telepon
                    </label>
                    <div class="relative">
                        <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                            <i class="fas fa-phone text-gray-400"></i>
                        </div>
                        <input 
                            type="tel" 
                            id="phone" 
                            name="phone" 
                            value="{{ old('phone') }}"
                            required 
                            class="block w-full pl-10 pr-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition-colors @error('phone') border-red-500 @enderror"
                            placeholder="08xxxxxxxxxx"
                        >
                    </div>
                </div>

                <!-- Password -->
                <div>
                    <label for="password" class="block text-sm font-medium text-gray-700 mb-2">
                        Password
                    </label>
                    <div class="relative" x-data="{ showPassword: false }">
                        <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                            <i class="fas fa-lock text-gray-400"></i>
                        </div>
                        <input 
                            :type="showPassword ? 'text' : 'password'" 
                            id="password" 
                            name="password" 
                            required
                            class="block w-full pl-10 pr-12 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition-colors"
                            placeholder="Minimal 6 karakter"
                        >
                        <button 
                            type="button" 
                            @click="showPassword = !showPassword"
                            class="absolute inset-y-0 right-0 pr-3 flex items-center"
                        >
                            <i :class="showPassword ? 'fas fa-eye-slash' : 'fas fa-eye'" class="text-gray-400 hover:text-gray-600"></i>
                        </button>
                    </div>
                </div>

                <!-- Confirm Password -->
                <div>
                    <label for="password_confirmation" class="block text-sm font-medium text-gray-700 mb-2">
                        Konfirmasi Password
                    </label>
                    <div class="relative" x-data="{ showPassword: false }">
                        <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                            <i class="fas fa-lock text-gray-400"></i>
                        </div>
                        <input 
                            :type="showPassword ? 'text' : 'password'" 
                            id="password_confirmation" 
                            name="password_confirmation" 
                            required
                            class="block w-full pl-10 pr-12 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition-colors"
                            placeholder="Ulangi password"
                        >
                        <button 
                            type="button" 
                            @click="showPassword = !showPassword"
                            class="absolute inset-y-0 right-0 pr-3 flex items-center"
                        >
                            <i :class="showPassword ? 'fas fa-eye-slash' : 'fas fa-eye'" class="text-gray-400 hover:text-gray-600"></i>
                        </button>
                    </div>
                </div>

                <!-- Terms -->
                <div class="flex items-start">
                    <input 
                        type="checkbox" 
                        id="terms" 
                        name="terms"
                        required
                        class="h-4 w-4 text-blue-600 focus:ring-blue-500 border-gray-300 rounded mt-1"
                    >
                    <label for="terms" class="ml-2 block text-sm text-gray-600">
                        Saya setuju dengan 
                        <a href="#" class="text-blue-600 hover:text-blue-800">Syarat & Ketentuan</a> 
                        dan 
                        <a href="#" class="text-blue-600 hover:text-blue-800">Kebijakan Privasi</a>
                    </label>
                </div>

                <!-- Submit Button -->
                <button 
                    type="submit"
                    class="w-full bg-gradient-to-r from-blue-600 to-blue-800 text-white py-3 px-4 rounded-lg font-semibold hover:from-blue-700 hover:to-blue-900 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:ring-offset-2 transition-all duration-300 transform hover:scale-[1.02]"
                >
                    <i class="fas fa-user-plus mr-2"></i>
                    Daftar Sekarang
                </button>

                <!-- Divider -->
                <div class="relative my-6">
                    <div class="absolute inset-0 flex items-center">
                        <div class="w-full border-t border-gray-300"></div>
                    </div>
                    <div class="relative flex justify-center text-sm">
                        <span class="px-4 bg-white text-gray-500">Atau daftar dengan</span>
                    </div>
                </div>

                <!-- Social Register -->
                <div class="grid grid-cols-2 gap-4">
                    <a href="{{ route('google.redirect') }}"
                        class="flex items-center justify-center px-4 py-3 border border-gray-300 rounded-lg hover:bg-gray-50 transition-colors"
                    >
                        <img src="https://www.google.com/favicon.ico" alt="Google" class="w-5 h-5 mr-2">
                        <span class="text-sm font-medium text-gray-700">Google</span>
                    </a>
                    <button 
                        type="button"
                        class="flex items-center justify-center px-4 py-3 border border-gray-300 rounded-lg hover:bg-gray-50 transition-colors"
                    >
                        <i class="fab fa-facebook text-blue-600 text-xl mr-2"></i>
                        <span class="text-sm font-medium text-gray-700">Facebook</span>
                    </button>
                </div>
            </form>

            <!-- Login Link -->
            <p class="mt-8 text-center text-gray-600">
                Sudah punya akun?
                <a href="{{ route('login') }}" class="text-blue-600 hover:text-blue-800 font-semibold">
                    Masuk di sini
                </a>
            </p>
        </div>

        <!-- Back to Home -->
        <div class="mt-6 text-center">
            <a href="{{ route('home') }}" class="text-gray-500 hover:text-gray-700 text-sm">
                <i class="fas fa-arrow-left mr-2"></i>
                Kembali ke Beranda
            </a>
        </div>
    </div>
</div>
@endsection
