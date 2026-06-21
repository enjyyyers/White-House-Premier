@extends('layouts.admin')

@section('title', 'Detail Percakapan')
@section('subtitle', 'Balas percakapan dengan pelanggan secara real-time.')

@section('content')
<div class="p-6 h-[calc(100vh-8rem)] flex flex-col">
    <div class="flex items-center justify-between mb-4">
        <div class="flex items-center space-x-4">
            <a href="{{ route('admin.chat.index') }}" class="text-gray-400 hover:text-gray-600">
                <i class="fas fa-arrow-left text-xl"></i>
            </a>
            <div>
                <h2 class="text-xl font-bold text-gray-800">{{ $conversation->subject }}</h2>
                <p class="text-sm text-gray-500">
                    {{ $conversation->user->name ?? 'Unknown' }} &middot;
                    {{ $conversation->user->email ?? '' }}
                    @if($conversation->status === 'closed')
                    &middot; <span class="text-red-500">Ditutup</span>
                    @endif
                </p>
            </div>
        </div>
        <div class="flex items-center space-x-2">
            @if($conversation->status === 'open')
            <form action="{{ route('admin.chat.close', $conversation->id) }}" method="POST" onsubmit="return confirm('Tutup percakapan ini?')">
                @csrf
                <button type="submit" class="px-4 py-2 bg-red-50 text-red-600 rounded-lg text-sm font-semibold hover:bg-red-100 transition border border-red-200">
                    <i class="fas fa-lock mr-2"></i>Tutup
                </button>
            </form>
            @endif
        </div>
    </div>

    @if(session('success'))
        <div class="mb-4 p-4 bg-green-100 text-green-700 rounded-lg text-sm">{{ session('success') }}</div>
    @endif
    @if(session('error'))
        <div class="mb-4 p-4 bg-red-100 text-red-700 rounded-lg text-sm">{{ session('error') }}</div>
    @endif

    <div class="flex-1 bg-white rounded-xl shadow-sm border border-gray-200 flex flex-col overflow-hidden">
        <div id="chat-messages" class="flex-1 p-6 space-y-4 overflow-y-auto bg-gray-50/50">
            @forelse($messages as $msg)
            <div class="flex {{ $msg->sender_type === 'admin' ? 'justify-end' : 'justify-start' }}">
                <div class="max-w-[70%] {{ $msg->sender_type === 'admin' ? 'bg-blue-600 text-white' : 'bg-white border border-gray-200 text-gray-800' }} rounded-2xl px-5 py-3 shadow-sm">
                    @if($msg->sender_type === 'user')
                    <p class="text-xs font-semibold text-gray-500 mb-1">{{ $msg->user->name ?? 'User' }}</p>
                    @endif
                    <p class="text-sm whitespace-pre-wrap">{{ $msg->message }}</p>
                    <div class="flex items-center justify-end gap-1 mt-1">
                        <span class="text-[10px] {{ $msg->sender_type === 'admin' ? 'text-blue-200' : 'text-gray-400' }}">
                            {{ $msg->created_at->format('H:i, d M') }}
                        </span>
                        @if($msg->sender_type === 'admin')
                        <i class="fas fa-check text-[10px] {{ $msg->is_read ? 'text-green-300' : 'text-blue-200' }}"></i>
                        @endif
                    </div>
                </div>
            </div>
            @empty
            <div class="text-center text-gray-400 py-12">Belum ada pesan.</div>
            @endforelse
        </div>

        @if($conversation->status === 'open')
        <form action="{{ route('admin.chat.send', $conversation->id) }}" method="POST" class="p-4 border-t border-gray-200 bg-white">
            @csrf
            <div class="flex gap-3">
                <input type="text" name="message" required placeholder="Ketik balasan..."
                       class="flex-1 px-4 py-3 border border-gray-300 rounded-xl focus:ring-2 focus:ring-blue-500 focus:border-blue-500 text-sm">
                <button type="submit" class="bg-blue-600 text-white px-6 py-3 rounded-xl hover:bg-blue-700 transition font-semibold">
                    <i class="fas fa-paper-plane mr-2"></i> Kirim
                </button>
            </div>
        </form>
        @else
        <div class="p-4 border-t border-gray-200 bg-gray-100 text-center text-sm text-gray-500">
            Percakapan ini sudah ditutup.
        </div>
        @endif
    </div>
</div>

<script>
    function scrollToBottom() {
        const container = document.getElementById('chat-messages');
        if (container) container.scrollTop = container.scrollHeight;
    }
    scrollToBottom();

    function pollMessages() {
        fetch('{{ route("admin.chat.fetch", $conversation->id) }}')
            .then(r => r.json())
            .then(messages => {
                const container = document.getElementById('chat-messages');
                if (!container) return;
                let html = '';
                messages.forEach(msg => {
                    const isAdmin = msg.sender_type === 'admin';
                    html += `
                        <div class="flex ${isAdmin ? 'justify-end' : 'justify-start'}">
                            <div class="max-w-[70%] ${isAdmin ? 'bg-blue-600 text-white' : 'bg-white border border-gray-200 text-gray-800'} rounded-2xl px-5 py-3 shadow-sm">
                                ${!isAdmin ? `<p class="text-xs font-semibold text-gray-500 mb-1">${escHtml(msg.sender_name)}</p>` : ''}
                                <p class="text-sm whitespace-pre-wrap">${escHtml(msg.message)}</p>
                                <div class="flex items-center justify-end gap-1 mt-1">
                                    <span class="text-[10px] ${isAdmin ? 'text-blue-200' : 'text-gray-400'}">${msg.created_at}</span>
                                    ${isAdmin ? `<i class="fas fa-check text-[10px] ${msg.is_read ? 'text-green-300' : 'text-blue-200'}"></i>` : ''}
                                </div>
                            </div>
                        </div>
                    `;
                });
                container.innerHTML = html;
                scrollToBottom();
            });
    }

    function escHtml(str) {
        const div = document.createElement('div');
        div.textContent = str;
        return div.innerHTML;
    }

    setInterval(pollMessages, 3000);
</script>
@endsection
