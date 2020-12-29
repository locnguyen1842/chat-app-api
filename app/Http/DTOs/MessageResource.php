<?php

namespace App\Http\DTOs;

class MessageResource extends BaseJsonResource
{
    public function toArray($request)
    {
        return [
            'id' => $this->id,
            'sender' => new UserResource($this->user),
            'type' => $this->type,
            'content' => $this->content,
            $this->mergeWhen($this->isFileMessage(), function () {
                return [
                    'files' => MessageFileResource::collection($this->files),
                ];
            }),
            'received_members' => UserReceivedMessageResource::collection($this->receivedUsers),
            'extra_data' => $this->extra_data,
            'created_at' => $this->created_at,
        ];
    }
}
