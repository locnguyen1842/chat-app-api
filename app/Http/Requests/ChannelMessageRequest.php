<?php

namespace App\Http\Requests;

use App\Enums\MessageType;

class ChannelMessageRequest extends BaseFormRequest
{
    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        if ($this->getMethod() == 'POST') {
            return [
                'user_id' => 'required|exists:App\Models\User,id',
                'type' => 'required|in:'.implode(',', MessageType::all()),
                'content' => 'nullable|required_if:type,'.implode(',', [MessageType::TEXT, MessageType::ADMIN]),
                'files' => 'array|required_if:type,'.MessageType::FILE,
                'files.*' => 'file|max:5120',
            ];
        }

        return [
            'note' => 'nullable|max:255',
        ];
    }
}
