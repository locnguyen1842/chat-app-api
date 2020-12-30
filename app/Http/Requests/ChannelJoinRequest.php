<?php

namespace App\Http\Requests;

class ChannelJoinRequest extends BaseFormRequest
{
    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'user_id' => 'required|exists:\App\Models\User,id|unique:\App\Models\UserChannel,user_id,null,id,channel_id,'. $this->route('channel')->id,
        ];
    }
}
