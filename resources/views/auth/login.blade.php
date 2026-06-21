@extends('layouts.app')

@section('title', 'Login - White House Premiere')

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
            <h2 class="mt-6 text-3xl font-bold text-gray-900">Selamat Datang Kembali</h2>
            <p class="mt-2 text-gray-600">Masuk ke akun Anda untuk melanjutkan</p>
        </div>

        <!-- Login Form Card -->
        <div class="bg-white rounded-2xl shadow-xl p-8">
            <!-- Alert Messages -->
            @if(session('success'))
            <div class="mb-6 p-4 bg-green-50 border border-green-200 rounded-lg flex items-center space-x-3">
                <i class="fas fa-check-circle text-green-500"></i>
                <span class="text-green-700">{{ session('success') }}</span>
            </div>
            @endif

            @if($errors->any())
            <div class="mb-6 p-4 bg-red-50 border border-red-200 rounded-lg">
                <div class="flex items-center space-x-3">
                    <i class="fas fa-exclamation-circle text-red-500"></i>
                    <span class="text-red-700">{{ $errors->first() }}</span>
                </div>
            </div>
            @endif

            <form method="POST" action="{{ route('login') }}" class="space-y-6">
                @csrf

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
                            autofocus
                            class="block w-full pl-10 pr-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition-colors @error('email') border-red-500 @enderror"
                            placeholder="nama@email.com"
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
                            placeholder="Masukkan password"
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

                <!-- Remember Me & Forgot Password -->
                <div class="flex items-center justify-between">
                    <div class="flex items-center">
                        <input 
                            type="checkbox" 
                            id="remember" 
                            name="remember"
                            class="h-4 w-4 text-blue-600 focus:ring-blue-500 border-gray-300 rounded"
                        >
                        <label for="remember" class="ml-2 block text-sm text-gray-700">
                            Ingat saya
                        </label>
                    </div>
                    <a href="{{ route('forgot-password') }}" class="text-sm text-blue-600 hover:text-blue-800 font-medium">
                        Lupa password?
                    </a>
                </div>

                <!-- Submit Button -->
                <button 
                    type="submit"
                    class="w-full bg-gradient-to-r from-blue-600 to-blue-800 text-white py-3 px-4 rounded-lg font-semibold hover:from-blue-700 hover:to-blue-900 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:ring-offset-2 transition-all duration-300 transform hover:scale-[1.02]"
                >
                    <i class="fas fa-sign-in-alt mr-2"></i>
                    Masuk
                </button>

                <!-- Divider -->
                <div class="relative my-6">
                    <div class="absolute inset-0 flex items-center">
                        <div class="w-full border-t border-gray-300"></div>
                    </div>
                    <div class="relative flex justify-center text-sm">
                        <span class="px-4 bg-white text-gray-500">Atau masuk dengan</span>
                    </div>
                </div>

                <!-- Social Login -->
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

            <!-- Register Link -->
            <p class="mt-8 text-center text-gray-600">
                Belum punya akun?
                <a href="{{ route('register') }}" class="text-blue-600 hover:text-blue-800 font-semibold">
                    Daftar sekarang
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
