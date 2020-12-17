<?php

namespace App\Models;

use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;

class User extends Authenticatable
{
    use Notifiable, HasApiTokens;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name',
        'email',
        'password',
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    public function isMemberOfChannel($channelId)
    {
        return $this->channels()->where('channels.id', $channelId)->exists();
    }

    public function channels()
    {
        return $this->belongsToMany(\App\Models\Channel::class, \App\Models\UserChannel::class)->withTimestamps();
    }
}
