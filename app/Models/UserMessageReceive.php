<?php

namespace App\Models;

class UserMessageReceive extends BaseModel
{
    protected $table = 'user_message_receive';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'user_id',
        'message_id',
    ];

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
        'created_at' => 'timestamp',
    ];
}
