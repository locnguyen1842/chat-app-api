<?php

namespace App\Http\DTOs;

class UserReceivedMessageResource extends BaseJsonResource
{
    public function toArray($request)
    {
        return [
            'id' => $this->id,
            'created_at' => $this->created_at,
        ];
    }
}
