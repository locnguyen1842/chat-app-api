<?php

namespace App\Broadcasting;

use App\Broadcasting\Abs\PresenceBC;
use App\Http\DTOs\ChannelResource;
use App\Models\Channel;
use App\Models\User;

class ChannelBC extends PresenceBC
{
    /**
     * Create a new channel instance.
     *
     * @return void
     */
    public function __construct()
    {
    }

    public function join(User $user, Channel $channel)
    {
        if ($user->isMemberOfChannel($channel->id)) {
            return new ChannelResource($channel);
        }
    }
}
