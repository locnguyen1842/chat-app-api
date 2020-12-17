<?php

namespace App\Events;

use App\Http\DTOs\ChannelResource;
use App\Models\Channel;
use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Broadcasting\PresenceChannel;
use Illuminate\Broadcasting\PrivateChannel;
use Illuminate\Contracts\Broadcasting\ShouldBroadcast;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;

class ChannelRemoved implements ShouldBroadcast
{
    use Dispatchable, InteractsWithSockets, SerializesModels;

    /** @var Channel */
    public $channel;
    /**
     * Create a new event instance.
     *
     * @return void
     */
    public function __construct($channel)
    {
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
            new PresenceChannel('channels-'. $this->channel->id),
        ];
    }

    public function broadcastAs()
    {
        return 'channel-removed';
    }

    public function broadcastWith()
    {
        return [
            'channel' => new ChannelResource($this->channel),
        ];
    }

}
