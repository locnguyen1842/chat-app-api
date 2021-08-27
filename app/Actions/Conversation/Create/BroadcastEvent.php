<?php

namespace App\Actions\Conversation\Create;

use App\Actions\BaseAction;
use App\Events\ConversationCreated;

class BroadcastEvent extends BaseAction
{
    public function action($data)
    {
        ConversationCreated::broadcast($data);

        return $data;
    }
}
