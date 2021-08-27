<?php

namespace App\Actions\Conversation\Create;

use App\Actions\BaseAction;
use Illuminate\Support\Facades\Validator;

class ValidateRequest extends BaseAction
{
    public function action($request)
    {
        return Validator::validate($request->all(), [
            'name' => 'required|max:255',
            'is_public' => 'boolean|nullable',
            'is_active' => 'boolean|nullable',
            'extra_data' => 'array|nullable',
            'member_ids' => 'array|nullable',
            'member_ids.*' => 'required|exists:\App\Models\User,id',
        ]);
    }
}
