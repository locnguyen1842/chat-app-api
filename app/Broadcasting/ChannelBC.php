<?php

namespace App\Broadcasting;

use App\Broadcasting\Abs\BaseBC;
use App\Http\DTOs\ChannelResource;
use App\Http\DTOs\UserResource;
use App\Models\Channel;
use App\Models\User;

class ChannelBC extends BaseBC
{
    public function join(User $user, Channel $channel)
    {
        if ($user->isMemberOfChannel($channel->id)) {
            return new UserResource($user);
        }
    }
}
