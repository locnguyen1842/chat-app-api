<?php

namespace App\Http\Controllers\Api;

use App\Events\ChannelCreated;
use App\Events\ChannelRemoved;
use App\Events\ChannelUpdated;
use App\Events\UserJoinedChannel;
use App\Events\UserLeftChannel;
use App\Http\DTOs\ChannelResource;
use App\Http\DTOs\SimpleCollection;
use App\Http\Requests\ChannelInviteRequest;
use App\Http\Requests\ChannelJoinRequest;
use App\Http\Requests\ChannelKickRequest;
use App\Http\Requests\ChannelRequest;
use App\Models\Channel;
use App\Models\User;
use Illuminate\Http\Request;

class ChannelController extends ApiController
{
    public function index(Request $request)
    {
        $this->authorize('index', Channel::class);

        $channels = Channel::active()->with(['members', 'lastMessage', 'lastMessage.user'])->paginate($request->size);

        return response(
            new SimpleCollection($channels, ChannelResource::class)
        );
    }

    public function store(ChannelRequest $request)
    {
        $channel = Channel::create($request->validated());

        broadcast(new ChannelCreated($channel));

        return response(new ChannelResource($channel));
    }

    public function update(ChannelRequest $request, Channel $channel)
    {
        $this->authorize('update', $channel);

        $channel->update($request->validated());

        broadcast(new ChannelUpdated($channel));

        return response()->noContent();
    }

    public function show(Channel $channel)
    {
        return response(new ChannelResource($channel));
    }

    public function destroy(Channel $channel)
    {
        $this->authorize('delete', $channel);

        \DB::transaction(function () use($channel) {
            broadcast(new ChannelRemoved($channel));

            $channel->deleteWithRelationships(['messages', 'members']);
        });
        
        return response()->noContent();
    }

    public function invite(ChannelInviteRequest $request, Channel $channel)
    {
        $this->authorize('invite', $channel);

        $channel->members()->syncWithoutDetaching($request->user_ids);

        broadcast(new UserJoinedChannel($request->user_ids, $channel));
    }

    public function join(ChannelJoinRequest $request, Channel $channel)
    {
        $this->authorizeForUser(User::find($request->user_id), 'join', $channel);

        $channel->members()->syncWithoutDetaching($request->user_id);

        broadcast(new UserJoinedChannel(\Arr::wrap($request->user_id), $channel));
    }
    
    public function kick(ChannelKickRequest $request, Channel $channel)
    {
        $this->authorize('kick', $channel);

        $channel->members()->detach($request->user_ids);

        broadcast(new UserLeftChannel($request->user_ids, $channel));
    }
}
