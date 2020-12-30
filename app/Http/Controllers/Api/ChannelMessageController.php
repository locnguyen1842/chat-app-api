<?php

namespace App\Http\Controllers\Api;

use App\Enums\MessageType;
use App\Events\ChannelMessageRemoved;
use App\Events\ChannelMessageSent;
use App\Http\DTOs\MessageResource;
use App\Http\DTOs\SimpleCollection;
use App\Http\Requests\ChannelMessageRequest;
use App\Models\Channel;
use App\Models\Message;
use App\Models\User;
use Illuminate\Http\Request;

class ChannelMessageController extends ApiController
{
    public function index(Request $request, Channel $channel)
    {
        $this->authorize('index', [Message::class, $channel]);

        $messages = $channel->messages()->with(['user', 'files'])->orderBy('created_at', 'desc')->paginate($request->size);

        return response(
            new SimpleCollection($messages, MessageResource::class)
        );
    }

    public function store(ChannelMessageRequest $request, Channel $channel)
    {
        $user = User::findOrFail($request->user_id);

        $this->authorizeForUser($user, 'sendMessage', $channel);

        $message = \DB::transaction(function () use ($request, $channel) {
            $validatedData = $request->validated();

            $message = $channel->messages()->create($validatedData);

            if ($validatedData['type'] === MessageType::FILE) {
                $message->saveFiles($validatedData['files']);
            }

            broadcast(new ChannelMessageSent($channel, $message))->toOthers();

            return $message;
        });

        return response(new MessageResource($message));
    }

    public function show(Channel $channel, Message $message)
    {
        $this->authorize('view', $message);

        return response(new MessageResource($message));
    }

    public function destroy(Channel $channel, Message $message)
    {
        $this->authorize('delete', $message);

        $message->is_removed = true;

        $message->save();

        broadcast(new ChannelMessageRemoved($channel, $message));

        return response()->noContent();
    }
}
