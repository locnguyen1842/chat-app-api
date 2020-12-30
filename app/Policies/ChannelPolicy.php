<?php

namespace App\Policies;

use App\Models\Channel;
use App\Models\User;
use Illuminate\Auth\Access\HandlesAuthorization;

class ChannelPolicy
{
    use HandlesAuthorization;

    public function index(User $user)
    {
        return $user->isAdmin();
    }

    public function view(User $user, Channel $channel)
    {
        return $user->isMemberOfChannel($channel->id);
    }

    public function update(User $user, Channel $channel)
    {
        return $user->isMemberOfChannel($channel->id);
    }

    public function sendMessage(User $user, Channel $channel)
    {
        return $user->isMemberOfChannel($channel->id);
    }

    public function delete(User $user, Channel $channel)
    {
        return $user->isMemberOfChannel($channel->id);
    }
    
    public function invite(User $user, Channel $channel)
    {
        return $user->isMemberOfChannel($channel->id);
    }
    
    public function join(User $user, Channel $channel)
    {
        return $channel->is_public;
    }

    public function kick(User $user, Channel $channel)
    {
        return $user->isMemberOfChannel($channel->id);
    }

    public function leave(User $user, Channel $channel)
    {
        return $user->isMemberOfChannel($channel->id);
    }
}
