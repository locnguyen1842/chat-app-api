<?php

namespace App\Http\Requests;

use App\Http\Requests\BaseFormRequest;

class ChannelRequest extends BaseFormRequest
{
    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'name' => 'required|max:255',
            'is_public' => 'boolean|nullable',
            'is_active' => 'boolean|nullable',
            'extra_data' => 'array|nullable'
        ];
    }

    /**
     * Set the default value for request field if this is null
     * This function will execute before validation so make sure your default value is match with the rule validation
     *
     * @return array
     */
    public function defaults(): array
    {
        if($this->getMethod() != 'POST') {
            return [];
        };

        return [
            'is_public' => false,
            'is_active' => true,
        ];
    }
}
