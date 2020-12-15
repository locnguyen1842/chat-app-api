<?php

namespace App\Http\Requests\Auth;

use App\Http\Requests\BaseFormRequest;

class UserRequest extends BaseFormRequest
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
            'email' => 'required|email|unique:\App\Models\User,email',
            'password' => 'required|confirmed',
        ];
    }
}
