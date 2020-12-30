<?php

namespace App\Events;

use App\Http\DTOs\ChannelResource;
use App\Http\DTOs\UserResource;
use App\Models\User;
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
     * @var array
     */
    public $userIds;

    /**
     * @var \App\Models\Channel
     */
    public $channel;

    /**
     * Create a new event instance.
     *
     * @return void
     */
    public function __construct($userIds, $channel)
    {
        $this->userIds = $userIds;
        $this->channel = $channel;
    }

    /**
     * Get the channels the event should broadcast on.
     *
     * @return \Illuminate\Broadcasting\Channel|array
     */
    public function broadcastOn()
    {
        $userChannels = [];

        foreach($this->userIds as $id) {
            $userChannels[] = new PrivateChannel("users-$id");
        }

        return array_merge([new PresenceChannel("channels-{$this->channel->id}")], $userChannels);
    }

    public function broadcastAs()
    {
        return 'user-left-channel';
    }

    public function broadcastWith()
    {
        return [
            'channel' => new ChannelResource($this->channel),
            'users' => UserResource::collection(User::whereIn('id', $this->userIds)->get()),
        ];
    }
}
