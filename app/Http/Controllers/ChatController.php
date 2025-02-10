<?php

namespace App\Http\Controllers;

use App\Events\MessageSent;
use App\Models\Message;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\User;

class ChatController extends Controller
{
    public function fetchMessages($userId)
    {
        $messages = Message::where(function ($query) use ($userId) {
            $query->where('from_id', Auth::id())->where('to_id', $userId);
        })->orWhere(function ($query) use ($userId) {
            $query->where('from_id', $userId)->where('to_id', Auth::id());
        })->orderBy('created_at', 'asc')->get();

        return response()->json($messages);
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
                    'id' => $user->id,
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

    public function sendMessage(Request $request)
    {
        $request->validate([
            'to_id' => 'required|exists:users,user_id',
            'body' => 'required|string',
            'attachment' => 'nullable|file|max:2048'
        ]);

        $attachmentPath = null;
        if ($request->hasFile('attachment')) {
            $attachmentPath = $request->file('attachment')->store('attachments', 'public');
        }

        $message = Message::create([
            'from_id' => Auth::id(),
            'to_id' => $request->to_id,
            'body' => $request->body,
            'attachment' => $attachmentPath,
            'seen' => false
        ]);

        broadcast(new MessageSent($message->load('fromUser', 'toUser')))->toOthers();

        return response()->json(['message' => $message], 201);
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
