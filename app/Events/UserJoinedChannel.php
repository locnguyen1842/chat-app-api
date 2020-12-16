<?php

namespace App\Events;

use App\Broadcasting\ChannelBC;
use App\Broadcasting\UserChannelBC;
use App\Http\DTOs\ChannelResource;
use Illuminate\Broadcasting\Channel;
use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Broadcasting\PresenceChannel;
use Illuminate\Broadcasting\PrivateChannel;
use Illuminate\Contracts\Broadcasting\ShouldBroadcast;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;

class UserJoinedChannel implements ShouldBroadcast
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
            new PrivateChannel("users-{$this->user->id}.channels"),
            new PrivateChannel("channels-{$this->channel->id}"),
        ];
    }

    public function broadcastAs()
    {
        return 'user-joined-channel';
    }

    public function broadcastWith()
    {
        return [
            'channel' => new ChannelResource($this->channel)
        ];
    }
}
