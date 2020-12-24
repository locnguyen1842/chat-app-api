<?php

namespace App\Broadcasting;

use App\Broadcasting\Abs\PrivateBC;
use App\Models\User;

class UserBC extends PrivateBC
{
    /**
     * Create a new channel instance.
     *
     * @return void
     */
    public function __construct()
    {
    }

    /**
     * Authenticate the user's access to the channel.
     *
     * @param  \App\Models\User  $user
     * @return array|bool
     */
    public function join(User $user, User $owner)
    {
        return $user->id === $owner->id;
    }
}
