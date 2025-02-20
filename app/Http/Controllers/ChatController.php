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
            'body' => 'nullable|string',
            'attachment' => 'nullable|array',
            'attachment.*' => 'file|max:5120|mimes:jpg,jpeg,png,gif,pdf,doc,docx',
        ]);

        $attachmentPaths = [];
        if ($request->hasFile('attachment')) {
            foreach ($request->file('attachment') as $file) {
                // Preserve the original file name.
                $originalName = $file->getClientOriginalName();
                // Optionally, prepend a unique prefix to avoid name collisions:
                // $originalName = time() . '_' . $file->getClientOriginalName();
                $path = $file->storeAs('attachments', $originalName, 'public');
                $attachmentPaths[] = $path;
            }
        }

        $message = Message::create([
            'from_id' => Auth::id(),
            'to_id' => $request->to_id,
            'body' => $request->body,
            'seen' => false,
            'attachments' => $attachmentPaths,
        ]);

        broadcast(new MessageSent($message))->toOthers();

        return response()->json($message);
    }



    public function fetchChatUsers()
    {
        try {
            $userId = Auth::id();

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
                ->withCount(['messagesSent as unreadCount' => function ($query) use ($userId) {
                    $query->where('to_id', $userId)
                        ->where('seen', false);
                }])
                ->get();

            $formattedUsers = $users->map(function ($user) use ($userId) {
                $lastMessageReceived = $user->messagesReceived->first();
                $lastMessageSent = $user->messagesSent->first();

                if ($lastMessageReceived && $lastMessageSent) {
                    $lastMessage = $lastMessageReceived->created_at > $lastMessageSent->created_at
                        ? $lastMessageReceived
                        : $lastMessageSent;
                } else {
                    $lastMessage = $lastMessageReceived ?? $lastMessageSent;
                }

                return [
                    'id'              => $user->user_id,
                    'name'            => $user->name,
                    'avatar'          => $user->avatar ?? 'https://i.pravatar.cc/40?u=' . $user->user_id,
                    'lastMessage'     => $lastMessage ? $lastMessage->body : 'No messages yet',
                    'lastMessageDate' => $lastMessage ? $lastMessage->created_at->diffForHumans() : '',
                    'unreadCount'     => $user->unreadCount,
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
