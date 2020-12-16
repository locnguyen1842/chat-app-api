<?php

namespace App\Http\Controllers\Api;

use App\Exceptions\InvalidLogicException;
use App\Http\DTOs\ChannelResource;
use App\Http\DTOs\SimpleCollection;
use App\Http\Requests\ChannelRequest;
use App\Http\Requests\UserChannelRequest;
use App\Models\Channel;
use App\Models\User;
use App\Models\UserChannel;
use Illuminate\Http\Request;

class UserChannelController extends ApiController
{
    public function index(Request $request, User $user)
    {
        $channels = $user->channels()->paginate($request->size);

        return response(
            new SimpleCollection($channels, ChannelResource::class)
        );
    }

    public function store(UserChannelRequest $request, User $user)
    {
        // check if the user already exists in the channel
        if($user->channels()->where('channels.id', $request->channel_id)->exists()) {
            throw new InvalidLogicException('The user already exists in this channel!', 400);
        }

        $user->channels()->syncWithoutDetaching([
            $request->channel_id => \Arr::except($request->validated(), 'channel_id')
        ]);

        return response()->noContent();
    }

    public function update(UserChannelRequest $request,User $user, Channel $channel)
    {
        $user->channels()->updateExistingPivot($channel, $request->validated());

        return response()->noContent();
    }

    public function destroy(User $user, Channel $channel)
    {
        $user->channels()->detach($channel);

        return response()->noContent();
    }
}
