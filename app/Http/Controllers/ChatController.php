<?php

namespace App\Http\Controllers;

use App\Models\Conversation;
use App\Models\Message;
use App\Events\NewMessageEvent;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;

class ChatController extends Controller
{
    public function index()
    {
        $conversations = Conversation::where('user_id', Auth::id())
            ->with('latestMessage')
            ->withCount(['messages as unread_count' => function ($q) {
                $q->whereNull('read_at')->where('sender_type', 'admin');
            }])
            ->latest('last_message_at')
            ->get();

        $unreadCount = $conversations->sum('unread_count');

        return view('pages.chat', compact('conversations', 'unreadCount'));
    }

    public function show($id)
    {
        $conversation = Conversation::where('user_id', Auth::id())->findOrFail($id);
        $conversation->messages()->where('sender_type', 'admin')->whereNull('read_at')->update(['read_at' => now()]);

        $messages = $conversation->messages()->with('user')->oldest()->get();
        $conversations = Conversation::where('user_id', Auth::id())
            ->with('latestMessage')
            ->latest('last_message_at')
            ->get();

        return view('pages.chat', compact('conversations', 'conversation', 'messages'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'subject' => 'required|string|max:255',
            'message' => 'required|string',
        ]);

        $conversation = Conversation::create([
            'user_id' => Auth::id(),
            'subject' => $request->subject,
            'status' => 'open',
            'last_message_at' => now(),
        ]);

        $message = Message::create([
            'conversation_id' => $conversation->id,
            'user_id' => Auth::id(),
            'message' => $request->message,
            'sender_type' => 'user',
        ]);

        try {
            broadcast(new NewMessageEvent($message, $conversation));
        } catch (\Exception $e) {
            Log::warning('Broadcast gagal: ' . $e->getMessage());
        }

        return redirect()->route('chat.show', $conversation->id)
            ->with('success', 'Pesan berhasil dikirim.');
    }

    public function sendMessage(Request $request, $id)
    {
        $request->validate(['message' => 'required|string']);

        $conversation = Conversation::where('user_id', Auth::id())->findOrFail($id);

        if ($conversation->status === 'closed') {
            return redirect()->back()->with('error', 'Percakapan ini sudah ditutup.');
        }

        $message = Message::create([
            'conversation_id' => $conversation->id,
            'user_id' => Auth::id(),
            'message' => $request->message,
            'sender_type' => 'user',
        ]);

        $conversation->update(['last_message_at' => now()]);

        try {
            broadcast(new NewMessageEvent($message, $conversation));
        } catch (\Exception $e) {
            Log::warning('Broadcast gagal: ' . $e->getMessage());
        }

        return redirect()->back();
    }

    public function fetchMessages($id)
    {
        $conversation = Conversation::where('user_id', Auth::id())->findOrFail($id);
        $conversation->messages()->where('sender_type', 'admin')->whereNull('read_at')->update(['read_at' => now()]);

        $messages = $conversation->messages()->with('user')->oldest()->get()->map(function ($msg) {
            return [
                'id' => $msg->id,
                'message' => $msg->message,
                'sender_type' => $msg->sender_type,
                'sender_name' => $msg->user?->name ?? 'Admin',
                'created_at' => $msg->created_at->diffForHumans(),
                'is_read' => !is_null($msg->read_at),
            ];
        });

        return response()->json($messages);
    }
}
