<?php

namespace App\Policies;

use App\Models\Channel;
use App\Models\Message;
use App\Models\User;
use Illuminate\Auth\Access\HandlesAuthorization;

class MessagePolicy
{
    use HandlesAuthorization;

    public function index(User $user, Channel $channel)
    {
        return $user->isMemberOfChannel($channel->id);
    }

    public function view(User $user, Message $message)
    {
        if(!$message->is_removed) {
            return $user->isMemberOfChannel($message->channel->id);
        }
    }

    public function delete(User $user, Message $message)
    {
        if($user->isMemberOfChannel($message->channel->id)) {
            return $user->id === $message->user_id;
        }
    }
    
    public function markAsReceived(User $user, Message $message)
    {
        return $user->isMemberOfChannel($message->channel->id);
    }
}
