<?php

namespace App\Broadcasting;

use App\Broadcasting\Abs\BaseBC;
use App\Models\User;

class UserBC extends BaseBC
{
    public function join(User $user, User $owner)
    {
        return $user->id === $owner->id;
    }
}
