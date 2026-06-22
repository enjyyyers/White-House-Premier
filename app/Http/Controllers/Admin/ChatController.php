<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Conversation;
use App\Models\Message;
use App\Events\NewMessageEvent;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

class ChatController extends Controller
{
    public function index()
    {
        $conversations = Conversation::with(['user', 'latestMessage'])
            ->latest('last_message_at')
            ->get();

        $unreadCount = Message::where('sender_type', 'user')->whereNull('read_at')->count();

        return view('admin.chat.index', compact('conversations', 'unreadCount'));
    }

    public function show($id)
    {
        $conversation = Conversation::with('user')->findOrFail($id);
        $conversation->messages()->where('sender_type', 'user')->whereNull('read_at')->update(['read_at' => now()]);

        $conversations = Conversation::with(['user', 'latestMessage'])
            ->latest('last_message_at')
            ->get();

        $messages = $conversation->messages()->with('user')->oldest()->get();
        $unreadCount = Message::where('sender_type', 'user')->whereNull('read_at')->count();

        return view('admin.chat.show', compact('conversations', 'conversation', 'messages', 'unreadCount'));
    }

    public function sendMessage(Request $request, $id)
    {
        $request->validate(['message' => 'required|string']);

        $conversation = Conversation::findOrFail($id);

        if ($conversation->status === 'closed') {
            return redirect()->back()->with('error', 'Percakapan ini sudah ditutup.');
        }

        $message = Message::create([
            'conversation_id' => $conversation->id,
            'user_id' => auth()->id(),
            'message' => $request->message,
            'sender_type' => 'admin',
        ]);

        $conversation->update(['last_message_at' => now()]);

        try {
            broadcast(new NewMessageEvent($message, $conversation));
        } catch (\Exception $e) {
            Log::warning('Broadcast gagal: ' . $e->getMessage());
        }

        return redirect()->back();
    }

    public function close($id)
    {
        $conversation = Conversation::findOrFail($id);
        $conversation->update(['status' => 'closed']);

        return redirect()->back()->with('success', 'Percakapan ditutup.');
    }

    public function fetchMessages($id)
    {
        $conversation = Conversation::findOrFail($id);
        $conversation->messages()->where('sender_type', 'user')->whereNull('read_at')->update(['read_at' => now()]);

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

    public function destroy($id)
    {
        $conversation = Conversation::findOrFail($id);
        $conversation->messages()->delete();
        $conversation->delete();

        return redirect()->route('admin.chat.index')->with('success', 'Percakapan berhasil dihapus.');
    }

    public function unreadCount()
    {
        $count = Message::where('sender_type', 'user')->whereNull('read_at')->count();
        return response()->json(['count' => $count]);
    }
}
