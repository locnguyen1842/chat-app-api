<?php

namespace App\Http\Controllers\Api;

use App\Enums\MessageType;
use App\Http\DTOs\MessageResource;
use App\Http\DTOs\SimpleCollection;
use App\Http\Requests\ChannelMessageRequest;
use App\Models\Channel;
use App\Models\Message;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Validation\UnauthorizedException;

class ChannelMessageController extends ApiController
{
    public function index(Request $request, Channel $channel)
    {
        $messages = $channel->messages()->with(['user', 'files'])->orderBy('created_at', 'desc')->paginate($request->size);

        return response(
            new SimpleCollection($messages, MessageResource::class)
        );
    }

    public function store(ChannelMessageRequest $request, Channel $channel)
    {
        $user = User::find($request->user_id);

        if (! $user->isMemberOfChannel($channel->id)) {
            throw new UnauthorizedException('You are not member of this channel!');
        }

        $message = \DB::transaction(function () use ($request, $channel) {
            $validatedData = $request->validated();

            $message = $channel->messages()->create($validatedData);

            if ($validatedData['type'] === MessageType::FILE) {
                $message->saveFiles($validatedData['files']);
            }

            return $message;
        });

        return response(new MessageResource($message));
    }

    public function show(Channel $channel, Message $message)
    {
        return response(new MessageResource($message));
    }

    public function destroy(Channel $channel, Message $message)
    {
        $message->is_removed = true;
        $message->save();

        return response()->noContent();
    }
}
