<?php

namespace App\Events;

use App\Http\DTOs\ConversationResource;
use App\Models\Channel;
use App\Models\Conversation;
use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Contracts\Broadcasting\ShouldBroadcast;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;

class ConversationCreated implements ShouldBroadcast
{
    use Dispatchable, InteractsWithSockets, SerializesModels;

    public Conversation $conversation;

    /**
     * Create a new event instance.
     *
     * @return void
     */
    public function __construct(Conversation $conversation)
    {
        $this->conversation = $conversation;
    }

    /**
     * Get the channels the event should broadcast on.
     *
     * @return \Illuminate\Broadcasting\Channel|array
     */
    public function broadcastOn()
    {
        return [
            new \Illuminate\Broadcasting\Channel('conversations'),
        ];
    }

    public function broadcastAs()
    {
        return 'conversation-created';
    }

    public function broadcastWith()
    {
        return [
            'conversation' => new ConversationResource($this->conversation),
        ];
    }
}
