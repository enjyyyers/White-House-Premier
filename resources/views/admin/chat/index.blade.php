@extends('layouts.admin')

@section('title', 'Chat Pelanggan')
@section('subtitle', 'Kelola percakapan real-time dengan pelanggan.')

@section('content')
<div class="p-6">

    @if(session('success'))
        <div class="mb-4 p-4 bg-green-100 text-green-700 rounded-lg text-sm">{{ session('success') }}</div>
    @endif

    <div class="bg-white rounded-xl shadow-sm border border-gray-100 overflow-hidden">
        <table class="w-full text-left">
            <thead class="bg-gray-50 border-b">
                <tr>
                    <th class="px-6 py-4 text-xs font-bold text-gray-400 uppercase">Pelanggan</th>
                    <th class="px-6 py-4 text-xs font-bold text-gray-400 uppercase">Subjek</th>
                    <th class="px-6 py-4 text-xs font-bold text-gray-400 uppercase">Status</th>
                    <th class="px-6 py-4 text-xs font-bold text-gray-400 uppercase">Pesan Terakhir</th>
                    <th class="px-6 py-4 text-xs font-bold text-gray-400 uppercase text-center">Aksi</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-gray-100">
                @forelse($conversations as $conv)
                <tr class="{{ $conv->latestMessage && $conv->latestMessage->sender_type === 'user' && !$conv->latestMessage->is_read ? 'bg-blue-50/50' : '' }}">
                    <td class="px-6 py-4">
                        <div class="flex items-center">
                            <div class="h-10 w-10 rounded-full bg-blue-100 flex items-center justify-center text-blue-600 font-bold mr-3">
                                {{ substr($conv->user->name ?? '?', 0, 1) }}
                            </div>
                            <div>
                                <div class="font-bold text-gray-800">{{ $conv->user->name ?? 'Unknown' }}</div>
                                <div class="text-xs text-gray-400">{{ $conv->user->email ?? '' }}</div>
                            </div>
                        </div>
                    </td>
                    <td class="px-6 py-4 text-sm font-medium text-gray-700">{{ $conv->subject }}</td>
                    <td class="px-6 py-4">
                        @if($conv->status === 'open')
                            <span class="px-3 py-1.5 rounded-full text-xs font-bold uppercase bg-green-100 text-green-700">Aktif</span>
                        @else
                            <span class="px-3 py-1.5 rounded-full text-xs font-bold uppercase bg-gray-100 text-gray-500">Ditutup</span>
                        @endif
                    </td>
                    <td class="px-6 py-4">
                        <div class="text-sm text-gray-600 truncate max-w-[200px]">{{ $conv->latestMessage?->message ?? '-' }}</div>
                        <div class="text-xs text-gray-400">{{ $conv->last_message_at?->diffForHumans() ?? $conv->created_at->diffForHumans() }}</div>
                    </td>
                    <td class="px-6 py-4 text-center">
                        <div class="flex items-center justify-center gap-2">
                            <a href="{{ route('admin.chat.show', $conv->id) }}"
                               class="inline-flex items-center px-4 py-2 bg-blue-600 text-white rounded-lg text-sm font-semibold hover:bg-blue-700 transition">
                                <i class="fas fa-reply mr-2"></i> Balas
                            </a>
                            <form action="{{ route('admin.chat.destroy', $conv->id) }}" method="POST" class="inline"
                                  onsubmit="return confirm('Yakin ingin menghapus percakapan ini?')">
                                @csrf
                                @method('DELETE')
                                <button type="submit"
                                        class="inline-flex items-center px-4 py-2 bg-red-600 text-white rounded-lg text-sm font-semibold hover:bg-red-700 transition">
                                    <i class="fas fa-trash mr-2"></i> Hapus
                                </button>
                            </form>
                        </div>
                    </td>
                </tr>
                @empty
                <tr>
                    <td colspan="5" class="px-6 py-12 text-center text-gray-400">Belum ada percakapan.</td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>
@endsection
