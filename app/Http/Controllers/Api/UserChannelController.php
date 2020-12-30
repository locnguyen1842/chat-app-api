<?php

namespace App\Http\Controllers\Api;

use App\Events\ChannelUpdated;
use App\Events\UserJoinedChannel;
use App\Events\UserLeftChannel;
use App\Exceptions\InvalidLogicException;
use App\Http\DTOs\ChannelResource;
use App\Http\DTOs\SimpleCollection;
use App\Http\Requests\UserChannelRequest;
use App\Models\Channel;
use App\Models\User;
use App\Models\UserChannel;
use Illuminate\Http\Request;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;

class UserChannelController extends ApiController
{
    public function index(Request $request, User $user)
    {
        $this->authorizeForUser($user, 'index', UserChannel::class);

        $channels = $user->channels()->with(['members', 'lastMessage', 'lastMessage.user'])->paginate($request->size);

        return response(
            new SimpleCollection($channels, ChannelResource::class)
        );
    }

    public function leave(User $user, Channel $channel)
    {
        $this->authorizeForUser($user, 'leave', $channel);

        $channel->members()->detach($user);

        broadcast(new UserLeftChannel(\Arr::wrap($user->id), $channel));

        return response()->noContent();
    }
}
