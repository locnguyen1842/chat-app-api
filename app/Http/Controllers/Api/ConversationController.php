<?php

namespace App\Http\Controllers\Api;

use App\Actions\Conversation as ConversationAction;
use App\Events\ChannelCreated;
use App\Events\ChannelRemoved;
use App\Events\ChannelUpdated;
use App\Http\DTOs\ChannelResource;
use App\Http\DTOs\ConversationResource;
use App\Http\DTOs\SimpleCollection;
use App\Http\Requests\ChannelRequest;
use App\Models\Conversation;
use Illuminate\Http\Request;

class ConversationController extends ApiController
{
    public function index(Request $request)
    {
        $channels = Conversation::active()->with(['members', 'lastMessage', 'lastMessage.user'])->paginate($request->size);

        return response(
            new SimpleCollection($channels, ChannelResource::class)
        );

    }

    public function store(Request $request)
    {
        $channel = pipeline()
            ->send($request)
            ->through([
                ConversationAction\Create\ValidateRequest::class,
                ConversationAction\Create\StoreToDatabase::class,
                ConversationAction\Create\BroadcastEvent::class,
            ])
            ->thenReturn();

        return response(new ConversationResource($channel));
    }

    public function update(Request $request, Conversation $conversation)
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
