<?php

namespace App\Http\Controllers;

use App\Events\MessageSent;
use App\Models\Message;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

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
