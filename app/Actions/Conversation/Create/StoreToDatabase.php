<?php

namespace App\Actions\Conversation\Create;

use App\Actions\BaseAction;
use App\Actions\Conversation\User\JoinConversation;
use App\Models\Conversation;
use Illuminate\Support\Facades\DB;

class StoreToDatabase extends BaseAction
{
    public function action($data)
    {
        return DB::transaction(function () use($data) {
            $conversation = Conversation::create($data);
            
            $this->do(JoinConversation::class, [$conversation, data_get($data, 'member_ids', [])]);

            return $conversation;
        });
    }
}
