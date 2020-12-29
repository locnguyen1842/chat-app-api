<?php

namespace App\Events;

use App\Http\DTOs\ChannelResource;
use App\Http\DTOs\MessageResource;
use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Broadcasting\PresenceChannel;
use Illuminate\Contracts\Broadcasting\ShouldBroadcast;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;

class UserReceivedMessage implements ShouldBroadcast
{
    use Dispatchable, InteractsWithSockets, SerializesModels;

    /**
     * @var \App\Models\User
     */
    public $user;

    /**
     * @var \App\Models\Message
     */
    public $message;

    /**
     * Create a new event instance.
     *
     * @return void
     */
    public function __construct($user, $message)
    {
        $this->user = $user;
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
            new PresenceChannel("channels-{$this->message->channel->id}"),
        ];
    }

    public function broadcastAs()
    {
        return 'user-received-message';
    }

    public function broadcastWith()
    {
        return [
            'channel' => new ChannelResource($this->message->channel),
            'message' => new MessageResource($this->message),
        ];
    }
}
