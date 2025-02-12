<?php

namespace App\Http\Controllers;

use App\Events\MessageSent;
use App\Models\Message;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\User;
use Illuminate\Support\Facades\Log;

class ChatController extends Controller
{
    public function fetchMessages($user_id)
    {
        $userId = Auth::id();

        $messages = Message::where(function ($query) use ($userId, $user_id) {
            $query->where('from_id', $userId)->where('to_id', $user_id);
        })
            ->orWhere(function ($query) use ($userId, $user_id) {
                $query->where('from_id', $user_id)->where('to_id', $userId);
            })
            ->orderBy('created_at', 'asc')
            ->get();

        return response()->json($messages);
    }

    public function sendMessage(Request $request)
    {
        $request->validate([
            'to_id' => 'required|exists:users,user_id',
            'body' => 'required|string',
        ]);

        $message = Message::create([
            'from_id' => Auth::id(),
            'to_id' => $request->to_id,
            'body' => $request->body,
            'seen' => false
        ]);

        // Log after message creation.
        Log::info('sendMessage: Message created', ['message' => $message]);

        broadcast(new MessageSent($message))->toOthers();

        // Log that the event was broadcasted.
        Log::info('sendMessage: MessageSent event broadcasted', ['message' => $message]);

        return response()->json($message);
    }

    public function fetchChatUsers()
    {
        try {
            $userId = Auth::id(); // Ensure user is authenticated

            // Fetch users that have sent/received messages with the current user
            $users = User::whereHas('messagesReceived', function ($query) use ($userId) {
                $query->where('from_id', $userId);
            })
                ->orWhereHas('messagesSent', function ($query) use ($userId) {
                    $query->where('to_id', $userId);
                })
                ->with([
                    'messagesReceived' => function ($query) use ($userId) {
                        $query->where('from_id', $userId)->latest();
                    },
                    'messagesSent' => function ($query) use ($userId) {
                        $query->where('to_id', $userId)->latest();
                    }
                ])
                ->get();

            // Format response
            $formattedUsers = $users->map(function ($user) use ($userId) {
                $lastMessage = $user->messagesReceived->first() ?? $user->messagesSent->first();
                return [
                    'id' => $user->user_id,
                    'name' => $user->name,
                    'avatar' => $user->avatar ?? 'https://i.pravatar.cc/40?u=' . $user->id,
                    'lastMessage' => $lastMessage ? $lastMessage->body : 'No messages yet',
                    'lastMessageDate' => $lastMessage ? $lastMessage->created_at->diffForHumans() : '',
                ];
            });

            return response()->json($formattedUsers, 200);
        } catch (\Exception $e) {
            return response()->json(['error' => $e->getMessage()], 500);
        }
    }

    public function markAsSeen($id)
    {
        $message = Message::where('id', $id)
            ->where('to_id', Auth::id())
            ->first();

        if ($message) {
            $message->seen = true;
            $message->save();
        }

        return response()->json(['success' => true]);
    }
}
