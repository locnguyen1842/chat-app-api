<?php

namespace App\Broadcasting;

use App\Http\DTOs\ChannelResource;
use App\Models\Channel;
use App\Models\User;

class ChannelBC
{
    /**
     * Create a new channel instance.
     *
     * @return void
     */
    public function __construct()
    {
    }

    /**
     * Authenticate the user's access to the channel.
     *
     * @param  \App\Models\User  $user
     * @return array|bool
     */
    public function join(User $user, Channel $channel)
    {
        if($user->isMemberOfChannel($channel->id)) {
            return new ChannelResource($channel);
        }
    }
}
