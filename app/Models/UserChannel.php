<?php

namespace App\Models;

class UserChannel extends BaseModel
{
    protected $table = 'user_channel';
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
    
    public function users()
    {
        return $this->belongsToMany(\App\Models\Channel::class, \App\Models\UserChannel::class);
    }
}
