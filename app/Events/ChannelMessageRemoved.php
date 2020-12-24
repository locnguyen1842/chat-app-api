<?php

namespace App\Events;

use App\Http\DTOs\ChannelResource;
use App\Http\DTOs\MessageResource;
use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Broadcasting\PresenceChannel;
use Illuminate\Contracts\Broadcasting\ShouldBroadcast;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;

class ChannelMessageRemoved implements ShouldBroadcast
{
    use Dispatchable, InteractsWithSockets, SerializesModels;

    /**
     * @var \App\Models\Channel
     */
    public $channel;

    /**
     * @var \App\Models\Message
     */
    public $message;

    /**
     * Create a new event instance.
     *
     * @return void
     */
    public function __construct($channel, $message)
    {
        $this->channel = $channel;
        $this->message = $message;
    }

    /**
     * Get the channels the event should broadcast on.
     *
     * @return \Illuminate\Broadcasting\Channel|array
     */
    public function broadcastOn()
    {
        return [
            new PresenceChannel("channels-{$this->channel->id}"),
        ];
    }

    public function broadcastAs()
    {
        return 'channel-message-removed';
    }

    public function broadcastWith()
    {
        return [
            'channel' => new ChannelResource($this->channel),
            'message' => new MessageResource($this->message),
        ];
    }
}
