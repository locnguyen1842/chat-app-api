<?php

namespace App\Http\Requests;

class ChannelRequest extends BaseFormRequest
{
    public function rules()
    {
        return [
            'name' => 'required|max:255',
            'is_public' => 'boolean|nullable',
            'is_active' => 'boolean|nullable',
            'extra_data' => 'array|nullable',
            'member_ids' => 'array|nullable',
            'member_ids.*' => 'required|exists:\App\Models\User,id',
        ];
    }

    public function defaults(): array
    {
        if ($this->getMethod() != 'POST') {
            return [];
        }

        return [
            'is_public' => false,
            'is_active' => true,
        ];
    }
}
