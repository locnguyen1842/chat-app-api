<?php

namespace App\Http\Requests;

class UserChannelRequest extends BaseFormRequest
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
                'channel_id' => 'required|exists:App\Models\Channel,id',
                'note' => 'nullable|max:255',
            ];
        }

        return [
            'note' => 'nullable|max:255',
        ];
    }
}
