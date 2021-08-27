<?php

namespace App\Actions\Conversation\User;

use App\Actions\BaseAction;

class JoinConversation extends BaseAction
{
    public function action($data)
    {
        list($conversation, $memberIds) = $data;
        
        return $conversation->members()->syncWithoutDetaching($memberIds);
    }

}
