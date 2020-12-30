<?php

namespace App\Http\Requests;

class ChannelInviteRequest extends BaseFormRequest
{
    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'user_ids' => 'array|required',
            'user_ids.*' => 'required|exists:\App\Models\User,id|unique:\App\Models\UserChannel,user_id,null,id,channel_id,'. $this->route('channel')->id,
        ];
    }
}
