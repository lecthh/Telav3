<?php

namespace App\Events;

use App\Models\Message;
use Illuminate\Broadcasting\PrivateChannel;
use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Queue\SerializesModels;
use Illuminate\Contracts\Broadcasting\ShouldBroadcast;
use Illuminate\Support\Facades\Log;

class MessageSent implements ShouldBroadcast
{
    use InteractsWithSockets, SerializesModels;

    public $message;

    public function __construct(Message $message)
    {
        // Optionally load relationships, e.g., fromUser
        $this->message = $message->load('fromUser');
        Log::info('MessageSent: Event constructed', ['message' => $this->message]);
    }

    public function broadcastOn()
    {
        // Create an array of the two user IDs and sort them for a consistent channel name.
        $ids = [$this->message->from_id, $this->message->to_id];
        sort($ids);
        $channelName = 'chat.' . $ids[0] . '.' . $ids[1];
        Log::info('MessageSent: Broadcasting on channel', ['channel' => $channelName]);
        return new PrivateChannel($channelName);
    }

    public function broadcastAs()
    {
        return 'message.sent';
    }
}
