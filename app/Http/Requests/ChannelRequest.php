<?php

namespace App\Http\Requests;

class ChannelRequest extends BaseFormRequest
{
    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        if ($this->getMethod() != 'POST') {
            return [
                'name' => 'required|max:255',
                'is_public' => 'boolean|nullable',
                'is_active' => 'boolean|nullable',
                'extra_data' => 'array|nullable',
            ];
        }

        return [
            'name' => 'required|max:255',
            'is_public' => 'boolean|nullable',
            'is_active' => 'boolean|nullable',
            'extra_data' => 'array|nullable',
            'user_ids' => 'array|required',
            'user_ids.*' => 'required|exists:\App\Models\User,id',
        ];
    }

    /**
     * Set the default value for request field if this is null
     * This function will execute before validation so make sure your default value is match with the rule validation.
     *
     * @return array
     */
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
