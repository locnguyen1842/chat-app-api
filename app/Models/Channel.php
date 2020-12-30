<?php

namespace App\Models;

use App\Traits\ModelRelationships;

class Channel extends BaseModel
{
    use ModelRelationships;
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name',
        'is_public',
        'is_active',
        'extra_data',
    ];

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
        'is_public' => 'boolean',
        'is_active' => 'boolean',
        'extra_data' => 'array',
        'created_at' => 'timestamp',
        'updated_at' => 'timestamp',
    ];

    public function scopeActive($query)
    {
        return $query->where('is_active', true);
    }

    public function scopeDisabled($query)
    {
        return $query->where('is_active', false);
    }

    public function scopePublic($query)
    {
        return $query->where('is_public', true);
    }

    public function scopePrivate($query)
    {
        return $query->where('is_public', false);
    }

    public function messages()
    {
        return $this->hasMany(\App\Models\Message::class);
    }

    public function members()
    {
        return $this->belongsToMany(\App\Models\User::class, \App\Models\UserChannel::class)->withTimestamps();
    }

    public function lastMessage()
    {
        return $this->hasOne(\App\Models\Message::class)->orderBy('created_at', 'desc');
    }
}
