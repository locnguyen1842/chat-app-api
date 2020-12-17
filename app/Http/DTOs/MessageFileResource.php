<?php

namespace App\Http\DTOs;

class MessageFileResource extends BaseJsonResource
{
    public function toArray($request)
    {
        return [
            'id' => $this->id,
            'name' => $this->name,
            'mime_type' => $this->mime_type,
            'size' => $this->size,
            'url' => $this->url,
        ];
    }
}
