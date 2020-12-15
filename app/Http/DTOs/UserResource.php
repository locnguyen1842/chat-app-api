<?php

namespace App\Http\DTOs;

class UserResource extends BaseJsonResource
{
    public function toArray($request)
    {
        return [
            'id' => $this->id,
            'name' => $this->name,
            'email' => $this->email,
            $this->mergeWhen($this->additional, $this->additional),
        ];
    }
}
