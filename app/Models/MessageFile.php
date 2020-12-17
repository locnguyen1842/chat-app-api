<?php

namespace App\Models;

class MessageFile extends BaseModel
{
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'message_id',
        'name',
        'mime_type',
        'size',
        'path',
    ];

    public function getUrlAttribute()
    {
        return \Storage::url($this->path);
    }
}
