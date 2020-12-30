<?php

namespace App\Policies;

use App\Models\Channel;
use App\Models\User;
use Illuminate\Auth\Access\HandlesAuthorization;

class UserChannelPolicy
{
    use HandlesAuthorization;

    public function index(User $user)
    {
        return true;
    }
}
