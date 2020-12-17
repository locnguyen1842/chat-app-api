<?php

namespace App\Http\DTOs;

use App\Enums\MessageType;

class MessageResource extends BaseJsonResource
{
    public function toArray($request)
    {
        return [
            'id' => $this->id,
            'user' => new UserResource($this->user),
            'type' => $this->type,
            'content' => $this->content,
            $this->mergeWhen($this->type === MessageType::FILE, function () {
                return [
                    'files' => MessageFileResource::collection($this->files),
                ];
            }),
            'extra_data' => $this->extra_data,
            'created_at' => $this->created_at,
        ];
    }
}
