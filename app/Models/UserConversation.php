<?php

namespace App\Models;

class UserConversation extends BaseModel
{
    protected $table = 'user_conversation';
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'channel_id',
        'user_id',
        'note',
    ];
}
