@extends('layouts.app')

@section('title', 'Profil Saya - White House Premiere')

@section('content')
<div class="min-h-screen bg-gray-50">
    <!-- Profile Header -->
    <div class="bg-gradient-to-r from-blue-800 to-blue-900 text-white">
        <div class="container mx-auto px-4 py-8">
            <div class="flex items-center space-x-4">
                <a href="{{ route('dashboard') }}" class="text-blue-200 hover:text-white">
                    <i class="fas fa-arrow-left text-xl"></i>
                </a>
                <div>
                    <h1 class="text-2xl font-bold">Profil Saya</h1>
                    <p class="text-blue-200">Kelola informasi akun Anda</p>
                </div>
            </div>
        </div>
    </div>

    <!-- Profile Content -->
    <div class="container mx-auto px-4 py-8">
        <!-- Alert Messages -->
        @if(session('success'))
        <div class="mb-6 p-4 bg-green-50 border border-green-200 rounded-lg flex items-center space-x-3">
            <i class="fas fa-check-circle text-green-500"></i>
            <span class="text-green-700">{{ session('success') }}</span>
        </div>
        @endif

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

        <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">
            <!-- Profile Card -->
            <div class="lg:col-span-1">
                <div class="bg-white rounded-xl shadow-md p-6 text-center">
                    <!-- Avatar -->
                    @if($user->avatar)
                        <img src="{{ asset('storage/' . $user->avatar) }}" alt="{{ $user->name }}" class="w-32 h-32 mx-auto rounded-full object-cover mb-4">
                    @else
                        <div class="w-32 h-32 mx-auto bg-gradient-to-r from-gold to-yellow-400 rounded-full flex items-center justify-center text-blue-900 text-4xl font-bold mb-4">
                            {{ $user->initials }}
                        </div>
                    @endif
                    <h2 class="text-xl font-bold text-gray-900">{{ $user->name }}</h2>
                    <p class="text-gray-500">{{ $user->email }}</p>
                    
                    <div class="mt-6 pt-6 border-t border-gray-100">
                        <div class="flex items-center justify-center space-x-2 text-gray-600">
                            <i class="fas fa-calendar-alt"></i>
                            <span class="text-sm">Bergabung sejak {{ $user->created_at ? $user->created_at->format('M Y') : 'Baru' }}</span>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Profile Forms -->
            <div class="lg:col-span-2 space-y-6">
                <!-- Personal Information -->
                <div class="bg-white rounded-xl shadow-md">
                    <div class="p-6 border-b border-gray-100">
                        <h2 class="text-xl font-bold text-gray-900">Informasi Pribadi</h2>
                        <p class="text-gray-500 text-sm mt-1">Perbarui informasi profil Anda</p>
                    </div>
                    <div class="p-6">
                        <form method="POST" action="{{ route('profile.update') }}" enctype="multipart/form-data" class="space-y-5">
                            @csrf
                            @method('PUT')

                            <div class="grid grid-cols-1 md:grid-cols-2 gap-5">
                                <!-- Name -->
                                <div>
                                    <label for="name" class="block text-sm font-medium text-gray-700 mb-2">
                                        Nama Lengkap
                                    </label>
                                    <input 
                                        type="text" 
                                        id="name" 
                                        name="name" 
                                        value="{{ old('name', $user->name) }}"
                                        required
                                        class="block w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition-colors"
                                    >
                                </div>

                                <!-- Email -->
                                <div>
                                    <label for="email" class="block text-sm font-medium text-gray-700 mb-2">
                                        Email Address
                                    </label>
                                    <input 
                                        type="email" 
                                        id="email" 
                                        name="email" 
                                        value="{{ old('email', $user->email) }}"
                                        required
                                        class="block w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition-colors"
                                    >
                                </div>

                                <!-- Phone -->
                                <div>
                                    <label for="phone" class="block text-sm font-medium text-gray-700 mb-2">
                                        Nomor Telepon
                                    </label>
                                    <input 
                                        type="tel" 
                                        id="phone" 
                                        name="phone" 
                                        value="{{ old('phone', $user->phone) }}"
                                        required
                                        class="block w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition-colors"
                                    >
                                </div>

                                <!-- Address -->
                                <div>
                                    <label for="address" class="block text-sm font-medium text-gray-700 mb-2">
                                        Alamat
                                    </label>
                                    <input 
                                        type="text" 
                                        id="address" 
                                        name="address" 
                                        value="{{ old('address', $user->address) }}"
                                        class="block w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition-colors"
                                        placeholder="Alamat lengkap"
                                    >
                                </div>

                                <!-- Avatar Upload -->
                                <div>
                                    <label for="avatar" class="block text-sm font-medium text-gray-700 mb-2">
                                        Foto Profil
                                    </label>
                                    <input 
                                        type="file" 
                                        id="avatar" 
                                        name="avatar" 
                                        accept="image/*"
                                        class="block w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition-colors"
                                    >
                                </div>
                            </div>

                            <div class="flex justify-end">
                                <button 
                                    type="submit"
                                    class="bg-blue-600 text-white px-6 py-3 rounded-lg font-semibold hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:ring-offset-2 transition-colors"
                                >
                                    <i class="fas fa-save mr-2"></i>
                                    Simpan Perubahan
                                </button>
                            </div>
                        </form>
                    </div>
                </div>

                <!-- Change Password -->
                <div class="bg-white rounded-xl shadow-md">
                    <div class="p-6 border-b border-gray-100">
                        <h2 class="text-xl font-bold text-gray-900">Ubah Password</h2>
                        <p class="text-gray-500 text-sm mt-1">Pastikan akun Anda menggunakan password yang kuat</p>
                    </div>
                    <div class="p-6">
                        <form method="POST" action="{{ route('password.update') }}" class="space-y-5">
                            @csrf
                            @method('PUT')

                            <!-- Current Password -->
                            <div>
                                <label for="current_password" class="block text-sm font-medium text-gray-700 mb-2">
                                    Password Saat Ini
                                </label>
                                <div class="relative" x-data="{ showPassword: false }">
                                    <input 
                                        :type="showPassword ? 'text' : 'password'" 
                                        id="current_password" 
                                        name="current_password" 
                                        required
                                        class="block w-full px-4 py-3 pr-12 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition-colors"
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

                            <div class="grid grid-cols-1 md:grid-cols-2 gap-5">
                                <!-- New Password -->
                                <div>
                                    <label for="password" class="block text-sm font-medium text-gray-700 mb-2">
                                        Password Baru
                                    </label>
                                    <div class="relative" x-data="{ showPassword: false }">
                                        <input 
                                            :type="showPassword ? 'text' : 'password'" 
                                            id="password" 
                                            name="password" 
                                            required
                                            class="block w-full px-4 py-3 pr-12 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition-colors"
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

                                <!-- Confirm New Password -->
                                <div>
                                    <label for="password_confirmation" class="block text-sm font-medium text-gray-700 mb-2">
                                        Konfirmasi Password Baru
                                    </label>
                                    <div class="relative" x-data="{ showPassword: false }">
                                        <input 
                                            :type="showPassword ? 'text' : 'password'" 
                                            id="password_confirmation" 
                                            name="password_confirmation" 
                                            required
                                            class="block w-full px-4 py-3 pr-12 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition-colors"
                                            placeholder="Ulangi password baru"
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
                            </div>

                            <div class="flex justify-end">
                                <button 
                                    type="submit"
                                    class="bg-gold text-blue-900 px-6 py-3 rounded-lg font-semibold hover:bg-yellow-400 focus:outline-none focus:ring-2 focus:ring-gold focus:ring-offset-2 transition-colors"
                                >
                                    <i class="fas fa-key mr-2"></i>
                                    Update Password
                                </button>
                            </div>
                        </form>
                    </div>
                </div>

                <!-- Delete Account -->
                <div class="bg-white rounded-xl shadow-md border border-red-100">
                    <div class="p-6 border-b border-red-100">
                        <h2 class="text-xl font-bold text-red-600">Zona Berbahaya</h2>
                        <p class="text-gray-500 text-sm mt-1">Tindakan ini tidak dapat dibatalkan</p>
                    </div>
                    <div class="p-6">
                        <div class="flex items-center justify-between">
                            <div>
                                <h3 class="font-medium text-gray-900">Hapus Akun</h3>
                                <p class="text-gray-500 text-sm">Semua data Anda akan dihapus secara permanen</p>
                            </div>
                            <button 
                                type="button"
                                onclick="confirm('Apakah Anda yakin ingin menghapus akun? Tindakan ini tidak dapat dibatalkan.') && document.getElementById('delete-form').submit()"
                                class="bg-red-500 text-white px-6 py-2 rounded-lg font-semibold hover:bg-red-600 transition-colors"
                            >
                                <i class="fas fa-trash-alt mr-2"></i>
                                Hapus Akun
                            </button>
                            <form id="delete-form" action="{{ route('profile.destroy') }}" method="POST" class="hidden">
                                @csrf
                                @method('DELETE')
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
