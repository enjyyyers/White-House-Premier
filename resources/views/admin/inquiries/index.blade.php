@extends('layouts.admin')

@section('title', 'Inquiries')
@section('subtitle', 'Daftar pertanyaan dari pengunjung website.')

@section('content')
<div class="p-6">

    @if(session('success'))
        <div class="mb-4 p-4 bg-green-100 text-green-700 rounded-lg text-sm">{{ session('success') }}</div>
    @endif

    <div class="bg-white rounded-xl shadow-sm border border-gray-100 overflow-hidden">
        <table class="w-full text-left">
            <thead class="bg-gray-50 border-b">
                <tr>
                    <th class="px-6 py-4 text-xs font-bold text-gray-400 uppercase">Pengirim</th>
                    <th class="px-6 py-4 text-xs font-bold text-gray-400 uppercase">Subjek</th>
                    <th class="px-6 py-4 text-xs font-bold text-gray-400 uppercase">Status</th>
                    <th class="px-6 py-4 text-xs font-bold text-gray-400 uppercase">Tanggal</th>
                    <th class="px-6 py-4 text-xs font-bold text-gray-400 uppercase text-center">Aksi</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-gray-100">
                @forelse($inquiries as $inquiry)
                <tr class="{{ $inquiry->is_replied ? '' : 'bg-blue-50/50' }}">
                    <td class="px-6 py-4">
                        <div class="flex items-center">
                            <div class="h-10 w-10 rounded-full bg-blue-100 flex items-center justify-center text-blue-600 font-bold mr-3">
                                {{ substr($inquiry->name, 0, 1) }}
                            </div>
                            <div>
                                <div class="font-bold text-gray-800">{{ $inquiry->name }}</div>
                                <div class="text-xs text-gray-400">{{ $inquiry->email }} • {{ $inquiry->phone }}</div>
                            </div>
                        </div>
                    </td>
                    <td class="px-6 py-4 text-sm font-medium text-gray-700">{{ $inquiry->subject }}</td>
                    <td class="px-6 py-4">
                        @if($inquiry->is_replied)
                            <span class="px-3 py-1.5 rounded-full text-xs font-bold uppercase bg-green-100 text-green-700">Dibalas</span>
                        @else
                            <span class="px-3 py-1.5 rounded-full text-xs font-bold uppercase bg-yellow-100 text-yellow-700">Baru</span>
                        @endif
                    </td>
                    <td class="px-6 py-4 text-sm text-gray-500">{{ $inquiry->created_at->format('d M Y H:i') }}</td>
                    <td class="px-6 py-4 text-center">
                        <div class="flex items-center justify-center space-x-2">
                            <a href="{{ route('admin.inquiries.show', $inquiry->id) }}" class="text-blue-600 hover:text-blue-800 text-sm font-medium">
                                <i class="fas fa-reply mr-1"></i> Balas
                            </a>
                            <form action="{{ route('admin.inquiries.destroy', $inquiry->id) }}" method="POST" class="inline" onsubmit="return confirm('Hapus pertanyaan ini?')">
                                @csrf @method('DELETE')
                                <button type="submit" class="text-red-500 hover:text-red-700 text-sm font-medium">
                                    <i class="fas fa-trash mr-1"></i> Hapus
                                </button>
                            </form>
                        </div>
                    </td>
                </tr>
                @empty
                <tr>
                    <td colspan="5" class="px-6 py-12 text-center text-gray-400">Belum ada pertanyaan masuk.</td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>
@endsection
