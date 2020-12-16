<?php

namespace App\Http\Controllers\Api;

use App\Http\DTOs\ChannelResource;
use App\Http\DTOs\SimpleCollection;
use App\Http\DTOs\UserResource;
use App\Http\Requests\ChannelRequest;
use App\Http\Requests\Auth\UserRequest;
use App\Models\Channel;
use App\Models\User;
use Illuminate\Http\Request;

class ChannelController extends ApiController
{
    public function index(Request $request)
    {
        $channels = Channel::active()->paginate($request->size);

        return response(
            new SimpleCollection($channels, ChannelResource::class)
        );
    }

    public function store(ChannelRequest $request)
    {
        $channel = Channel::create($request->validated());

        return response(new ChannelResource($channel));
    }

    public function update(ChannelRequest $request, Channel $channel)
    {
        $channel->update($request->validated());

        return response()->noContent();
    }

    public function show(Channel $channel)
    {
        return response(new ChannelResource($channel));
    }

    public function destroy(Channel $channel)
    {
        $channel->delete();

        return response()->noContent();
    }
}
