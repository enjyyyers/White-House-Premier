@extends('layouts.admin')

@section('title', 'Detail Inquiry')
@section('subtitle', 'Lihat dan balas pertanyaan dari pengunjung.')

@section('content')
<div class="p-6">
    <div class="mb-6 flex items-center space-x-4">
        <a href="{{ route('admin.inquiries.index') }}" class="text-gray-400 hover:text-gray-600">
            <i class="fas fa-arrow-left text-xl"></i>
        </a>
        <div>
            <h2 class="text-2xl font-bold text-gray-800">Detail Pertanyaan</h2>
            <p class="text-sm text-gray-500">Dari {{ $inquiry->name }}</p>
        </div>
    </div>

    @if(session('success'))
        <div class="mb-4 p-4 bg-green-100 text-green-700 rounded-lg text-sm">{{ session('success') }}</div>
    @endif

    <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">
        <div class="lg:col-span-2 space-y-6">
            <div class="bg-white rounded-xl shadow-sm border border-gray-100 p-6">
                <h3 class="font-bold text-gray-800 mb-4">Pesan</h3>
                <div class="bg-gray-50 rounded-lg p-4 mb-6">
                    <p class="text-gray-700 whitespace-pre-wrap">{{ $inquiry->message }}</p>
                </div>

                <div class="border-t border-gray-100 pt-4">
                    <h4 class="font-semibold text-gray-700 mb-3">Info Pengirim</h4>
                    <div class="grid grid-cols-2 gap-4 text-sm">
                        <div><span class="text-gray-400">Nama:</span> <span class="font-medium">{{ $inquiry->name }}</span></div>
                        <div><span class="text-gray-400">Email:</span> <span class="font-medium">{{ $inquiry->email }}</span></div>
                        <div><span class="text-gray-400">Telepon:</span> <span class="font-medium">{{ $inquiry->phone }}</span></div>
                        <div><span class="text-gray-400">Subjek:</span> <span class="font-medium">{{ $inquiry->subject }}</span></div>
                    </div>
                </div>
            </div>

            @if($inquiry->is_replied)
            <div class="bg-green-50 rounded-xl shadow-sm border border-green-100 p-6">
                <h3 class="font-bold text-green-800 mb-4 flex items-center">
                    <i class="fas fa-check-circle mr-2"></i> Balasan Anda
                </h3>
                <div class="bg-white rounded-lg p-4 border border-green-100">
                    <p class="text-gray-700 whitespace-pre-wrap">{{ $inquiry->reply }}</p>
                </div>
                <p class="text-xs text-green-600 mt-3">Dibalas pada {{ $inquiry->replied_at->format('d M Y H:i') }}</p>
            </div>
            @endif
        </div>

        <div class="lg:col-span-1">
            <div class="bg-white rounded-xl shadow-sm border border-gray-100 p-6">
                <h3 class="font-bold text-gray-800 mb-4">Balas Pesan</h3>

                @if($inquiry->is_replied)
                    <form action="{{ route('admin.inquiries.reply', $inquiry->id) }}" method="POST">
                        @csrf
                        <div class="mb-4">
                            <label for="reply" class="block text-sm font-medium text-gray-700 mb-2">Perbarui Balasan</label>
                            <textarea id="reply" name="reply" rows="6"
                                class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500"
                                placeholder="Tulis balasan...">{{ old('reply', $inquiry->reply) }}</textarea>
                        </div>
                        <button type="submit" class="w-full bg-blue-600 text-white py-3 rounded-lg font-semibold hover:bg-blue-700 transition-colors">
                            <i class="fas fa-paper-plane mr-2"></i> Perbarui Balasan
                        </button>
                    </form>
                @else
                    <form action="{{ route('admin.inquiries.reply', $inquiry->id) }}" method="POST">
                        @csrf
                        <div class="mb-4">
                            <label for="reply" class="block text-sm font-medium text-gray-700 mb-2">Tulis Balasan</label>
                            <textarea id="reply" name="reply" rows="6" required
                                class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500"
                                placeholder="Tulis balasan..."></textarea>
                        </div>
                        <button type="submit" class="w-full bg-blue-600 text-white py-3 rounded-lg font-semibold hover:bg-blue-700 transition-colors">
                            <i class="fas fa-paper-plane mr-2"></i> Kirim Balasan
                        </button>
                    </form>
                @endif
            </div>
        </div>
    </div>
</div>
@endsection
