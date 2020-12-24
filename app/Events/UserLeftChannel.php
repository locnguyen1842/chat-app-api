<?php

namespace App\Events;

use App\Http\DTOs\ChannelResource;
use App\Http\DTOs\UserResource;
use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Broadcasting\PresenceChannel;
use Illuminate\Broadcasting\PrivateChannel;
use Illuminate\Contracts\Broadcasting\ShouldBroadcast;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;

class UserLeftChannel implements ShouldBroadcast
{
    use Dispatchable, InteractsWithSockets, SerializesModels;

    /**
     * @var \App\Models\User
     */
    public $user;

    /**
     * @var \App\Models\Channel
     */
    public $channel;

    /**
     * Create a new event instance.
     *
     * @return void
     */
    public function __construct($user, $channel)
    {
        $this->user = $user;
        $this->channel = $channel;
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
            new PrivateChannel("users-{$this->user->id}"),
        ];
    }

    public function broadcastAs()
    {
        return 'user-left-channel';
    }

    public function broadcastWith()
    {
        return [
            'channel' => new ChannelResource($this->channel),
            'user' => new UserResource($this->user),
        ];
    }
}
