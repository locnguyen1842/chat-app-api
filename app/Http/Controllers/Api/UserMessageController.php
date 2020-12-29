<?php

namespace App\Http\Controllers\Api;

use App\Events\UserReceivedMessage;
use App\Models\Message;
use App\Models\User;

class UserMessageController extends ApiController
{
    public function markAsReceived(User $user, Message $message)
    {
        if($user->isReceivedMessage($message->id)) {
            return response()->noContent();
        }

        $user->receivedMessages()->syncWithoutDetaching($message);

        broadcast(new UserReceivedMessage($user, $message))->toOthers();

        return response()->noContent();
    }
}
