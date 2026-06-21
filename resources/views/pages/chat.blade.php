@extends('layouts.app')

@section('title', 'Percakapan Saya')

@section('content')
<div class="min-h-screen bg-gray-50 py-8">
    <div class="max-w-6xl mx-auto px-4 sm:px-6 lg:px-8">

        <div class="mb-6">
            <h1 class="text-2xl font-bold text-gray-900">Percakapan Saya</h1>
            <p class="text-sm text-gray-500">Riwayat komunikasi Anda dengan tim kami.</p>
        </div>

        @if(session('success'))
            <div class="mb-4 p-4 bg-green-100 text-green-700 rounded-lg text-sm">{{ session('success') }}</div>
        @endif
        @if(session('error'))
            <div class="mb-4 p-4 bg-red-100 text-red-700 rounded-lg text-sm">{{ session('error') }}</div>
        @endif

        <div class="bg-white rounded-xl shadow-sm border border-gray-200 overflow-hidden">
            <div class="grid grid-cols-1 md:grid-cols-3">
                <div class="md:col-span-1 border-r border-gray-200">
                    <div class="p-4 border-b border-gray-200 bg-gray-50">
                        <button onclick="document.getElementById('newChatModal').classList.remove('hidden')"
                                class="w-full bg-blue-600 text-white py-2.5 rounded-lg font-semibold hover:bg-blue-700 transition text-sm">
                            <i class="fas fa-plus mr-2"></i>Percakapan Baru
                        </button>
                    </div>

                    <div class="divide-y divide-gray-100 max-h-[500px] overflow-y-auto">
                        @forelse($conversations as $conv)
                        <a href="{{ route('chat.show', $conv->id) }}"
                           class="flex items-center p-4 hover:bg-gray-50 transition {{ isset($conversation) && $conversation->id === $conv->id ? 'bg-blue-50 border-l-4 border-blue-600' : '' }}">
                            <div class="flex-1 min-w-0">
                                <div class="flex items-center justify-between">
                                    <h4 class="font-semibold text-sm text-gray-800 truncate">{{ $conv->subject }}</h4>
                                    <span class="text-xs text-gray-400">{{ $conv->last_message_at?->diffForHumans() ?? $conv->created_at->diffForHumans() }}</span>
                                </div>
                                <p class="text-xs text-gray-500 mt-1 truncate">{{ $conv->latestMessage?->message ?? 'Belum ada pesan' }}</p>
                                <div class="flex items-center mt-1.5">
                                    @if($conv->status === 'closed')
                                    <span class="text-xs bg-gray-100 text-gray-500 px-2 py-0.5 rounded-full">Ditutup</span>
                                    @else
                                    <span class="text-xs bg-green-100 text-green-600 px-2 py-0.5 rounded-full">Aktif</span>
                                    @endif
                                    @php
                                        $unread = $conv->messages()->whereNull('read_at')->where('sender_type', 'admin')->count();
                                    @endphp
                                    @if($unread > 0)
                                    <span class="ml-2 bg-red-500 text-white text-xs w-5 h-5 rounded-full flex items-center justify-center font-bold">{{ $unread }}</span>
                                    @endif
                                </div>
                            </div>
                        </a>
                        @empty
                        <div class="p-8 text-center text-gray-400">
                            <i class="fas fa-comments text-4xl mb-3"></i>
                            <p class="text-sm">Belum ada percakapan.</p>
                            <p class="text-xs mt-1">Mulai percakapan baru dengan mengklik tombol di atas.</p>
                        </div>
                        @endforelse
                    </div>
                </div>

                <div class="md:col-span-2 flex flex-col">
                    @if(isset($conversation))
                    <div class="p-4 border-b border-gray-200 bg-gray-50 flex items-center justify-between">
                        <div>
                            <h3 class="font-bold text-gray-800">{{ $conversation->subject }}</h3>
                            <p class="text-xs text-gray-500">
                                @if($conversation->status === 'closed')
                                <span class="text-red-500">Percakapan ditutup</span>
                                @else
                                <span class="text-green-500">Aktif</span>
                                @endif
                                &middot; {{ $conversation->created_at->format('d M Y') }}
                            </p>
                        </div>
                    </div>

                    <div id="chat-messages" class="flex-1 p-4 space-y-4 max-h-[500px] overflow-y-auto bg-gray-50/50">
                        @forelse($messages as $msg)
                        <div class="flex {{ $msg->sender_type === 'user' ? 'justify-end' : 'justify-start' }}">
                            <div class="max-w-[80%] {{ $msg->sender_type === 'user' ? 'bg-blue-600 text-white' : 'bg-white border border-gray-200 text-gray-800' }} rounded-2xl px-4 py-3 shadow-sm">
                                <p class="text-sm">{{ $msg->message }}</p>
                                <div class="flex items-center justify-end gap-1 mt-1">
                                    <span class="text-[10px] {{ $msg->sender_type === 'user' ? 'text-blue-200' : 'text-gray-400' }}">
                                        {{ $msg->created_at->format('H:i') }}
                                    </span>
                                    @if($msg->sender_type === 'user')
                                    <i class="fas fa-check text-[10px] {{ $msg->is_read ? 'text-green-300' : 'text-blue-200' }}"></i>
                                    @endif
                                </div>
                            </div>
                        </div>
                        @empty
                        <div class="text-center text-gray-400 py-12">
                            <p>Belum ada pesan. Mulai percakapan!</p>
                        </div>
                        @endforelse
                    </div>

                    @if($conversation->status === 'open')
                    <form action="{{ route('chat.send', $conversation->id) }}" method="POST" class="p-4 border-t border-gray-200 bg-white">
                        @csrf
                        <div class="flex gap-3">
                            <input type="text" name="message" required placeholder="Ketik pesan..."
                                   class="flex-1 px-4 py-3 border border-gray-300 rounded-xl focus:ring-2 focus:ring-blue-500 focus:border-blue-500 text-sm">
                            <button type="submit" class="bg-blue-600 text-white px-6 py-3 rounded-xl hover:bg-blue-700 transition font-semibold">
                                <i class="fas fa-paper-plane"></i>
                            </button>
                        </div>
                    </form>
                    @else
                    <div class="p-4 border-t border-gray-200 bg-gray-100 text-center text-sm text-gray-500">
                        Percakapan ini sudah ditutup.
                    </div>
                    @endif
                    @else
                    <div class="flex items-center justify-center h-full p-12 text-center text-gray-400">
                        <div>
                            <i class="fas fa-comment-dots text-5xl mb-4"></i>
                            <p class="text-lg font-medium">Pilih percakapan</p>
                            <p class="text-sm">Atau mulai percakapan baru dengan tim kami.</p>
                        </div>
                    </div>
                    @endif
                </div>
            </div>
        </div>
    </div>
</div>

<div id="newChatModal" class="fixed inset-0 bg-black/50 z-50 flex items-center justify-center hidden">
    <div class="bg-white rounded-2xl p-6 max-w-lg w-full mx-4 shadow-2xl">
        <div class="flex items-center justify-between mb-4">
            <h3 class="text-lg font-bold text-gray-800">Percakapan Baru</h3>
            <button onclick="document.getElementById('newChatModal').classList.add('hidden')" class="text-gray-400 hover:text-gray-600 text-2xl leading-none">&times;</button>
        </div>
        <form action="{{ route('chat.store') }}" method="POST">
            @csrf
            <div class="mb-4">
                <label class="block text-sm font-medium text-gray-700 mb-1">Subjek</label>
                <input type="text" name="subject" required placeholder="Misal: Informasi properti"
                       class="w-full px-4 py-3 border border-gray-300 rounded-xl focus:ring-2 focus:ring-blue-500 focus:border-blue-500 text-sm">
            </div>
            <div class="mb-4">
                <label class="block text-sm font-medium text-gray-700 mb-1">Pesan</label>
                <textarea name="message" rows="4" required placeholder="Tulis pesan Anda..."
                          class="w-full px-4 py-3 border border-gray-300 rounded-xl focus:ring-2 focus:ring-blue-500 focus:border-blue-500 text-sm"></textarea>
            </div>
            <button type="submit" class="w-full bg-blue-600 text-white py-3 rounded-xl font-semibold hover:bg-blue-700 transition">
                <i class="fas fa-paper-plane mr-2"></i>Kirim Pesan
            </button>
        </form>
    </div>
</div>

<script>
    function scrollToBottom() {
        const container = document.getElementById('chat-messages');
        if (container) container.scrollTop = container.scrollHeight;
    }
    scrollToBottom();

    @if(isset($conversation))
    function pollMessages() {
        fetch('{{ route("chat.fetch", $conversation->id) }}')
            .then(r => r.json())
            .then(messages => {
                const container = document.getElementById('chat-messages');
                if (!container) return;
                let html = '';
                messages.forEach(msg => {
                    const isUser = msg.sender_type === 'user';
                    html += `
                        <div class="flex ${isUser ? 'justify-end' : 'justify-start'}">
                            <div class="max-w-[80%] ${isUser ? 'bg-blue-600 text-white' : 'bg-white border border-gray-200 text-gray-800'} rounded-2xl px-4 py-3 shadow-sm">
                                <p class="text-sm">${escHtml(msg.message)}</p>
                                <div class="flex items-center justify-end gap-1 mt-1">
                                    <span class="text-[10px] ${isUser ? 'text-blue-200' : 'text-gray-400'}">${msg.created_at}</span>
                                    ${isUser ? `<i class="fas fa-check text-[10px] ${msg.is_read ? 'text-green-300' : 'text-blue-200'}"></i>` : ''}
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

    setInterval(pollMessages, 5000);
    @endif
</script>
@endsection
