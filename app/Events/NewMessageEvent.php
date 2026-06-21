<?php

namespace App\Events;

use App\Models\Message;
use App\Models\Conversation;
use Illuminate\Broadcasting\Channel;
use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Contracts\Broadcasting\ShouldBroadcast;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;

class NewMessageEvent implements ShouldBroadcast
{
    use Dispatchable, InteractsWithSockets, SerializesModels;

    public Message $message;
    public Conversation $conversation;

    public function __construct(Message $message, Conversation $conversation)
    {
        $this->message = $message;
        $this->conversation = $conversation;
    }

    public function broadcastOn(): array
    {
        return [
            new Channel('conversation.' . $this->conversation->id),
        ];
    }

    public function broadcastAs(): string
    {
        return 'new-message';
    }

    public function broadcastWith(): array
    {
        return [
            'id' => $this->message->id,
            'message' => $this->message->message,
            'sender_type' => $this->message->sender_type,
            'sender_name' => $this->message->user?->name ?? 'Admin',
            'created_at' => $this->message->created_at->toISOString(),
            'conversation_id' => $this->conversation->id,
        ];
    }
}
