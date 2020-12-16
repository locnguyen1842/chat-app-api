<?php

namespace App\Http\DTOs;

class ChannelResource extends BaseJsonResource
{
    public function toArray($request)
    {
        return [
            'id' => $this->id,
            'name' => $this->name,
            'is_public' => $this->is_public,
            'is_active' => $this->is_active,
            'extra_data' => $this->extra_data,
        ];
    }
}
