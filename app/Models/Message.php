<?php

namespace App\Models;

use App\Enums\MessageType;
use Illuminate\Http\UploadedFile;

class Message extends BaseModel
{
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'channel_id',
        'user_id',
        'type',
        'content',
        'extra_data',
    ];

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
        'extra_data' => 'array',
        'created_at' => 'timestamp',
    ];

    public function isFileMessage()
    {
        return $this->type === MessageType::FILE;
    }

    public function isTextMessage()
    {
        return $this->type === MessageType::TEXT;
    }

    public function isAdminMessage()
    {
        return $this->type === MessageType::ADMIN;
    }

    /**
     * @param UploadedFile[] $files
     */
    public function saveFiles(array $files)
    {
        $messageFiles = [];

        foreach ($files as $file) {
            if (! $file instanceof UploadedFile) {
                continue;
            }

            $path = $file->store('message_files');

            $messageFiles[] = [
                'name' => $file->getClientOriginalName(),
                'mime_type' => $file->getClientMimeType(),
                'size' => (int) round($file->getSize() / 1000),
                'path' => $path,
                'message_id' => $this->id,
            ];
        }

        return $this->files()->createMany($messageFiles);
    }

    public function files()
    {
        return $this->hasMany(\App\Models\MessageFile::class);
    }

    public function user()
    {
        return $this->belongsTo(\App\Models\User::class);
    }
}
