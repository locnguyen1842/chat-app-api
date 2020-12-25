<?php

namespace App\Http\Controllers\Api;

use App\Events\ChannelCreated;
use App\Events\ChannelRemoved;
use App\Events\ChannelUpdated;
use App\Http\DTOs\ChannelResource;
use App\Http\DTOs\SimpleCollection;
use App\Http\Requests\ChannelRequest;
use App\Models\Channel;
use Illuminate\Http\Request;

class ChannelController extends ApiController
{
    public function index(Request $request)
    {
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
        $channel->delete();

        broadcast(new ChannelRemoved($channel));

        return response()->noContent();
    }
}
