<?php

namespace App\Events;

use App\Models\Inquiry;
use Illuminate\Broadcasting\Channel;
use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Contracts\Broadcasting\ShouldBroadcast;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;

class InquiryRepliedEvent implements ShouldBroadcast
{
    use Dispatchable, InteractsWithSockets, SerializesModels;

    public Inquiry $inquiry;

    public function __construct(Inquiry $inquiry)
    {
        $this->inquiry = $inquiry;
    }

    public function broadcastOn(): array
    {
        return [
            new Channel('inquiry.' . $this->inquiry->id),
        ];
    }

    public function broadcastAs(): string
    {
        return 'inquiry-replied';
    }

    public function broadcastWith(): array
    {
        return [
            'id' => $this->inquiry->id,
            'reply' => $this->inquiry->reply,
            'replied_at' => $this->inquiry->replied_at?->toISOString(),
        ];
    }
}
