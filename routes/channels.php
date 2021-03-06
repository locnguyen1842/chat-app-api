<?php

use App\Models\User;
use Illuminate\Support\Facades\Broadcast;

/*
|--------------------------------------------------------------------------
| Broadcast Channels
|--------------------------------------------------------------------------
|
| Here you may register all of the event broadcasting channels that your
| application supports. The given channel authorization callbacks are
| used to check if an authenticated user can listen to the channel.
|
*/

Broadcast::channel('users-{user}', App\Broadcasting\UserBC::class);
Broadcast::channel('channels-{channel}', App\Broadcasting\ChannelBC::class);
Broadcast::channel('channels', function (User $user) {
    return true;
});
