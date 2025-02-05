<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Message;
use Illuminate\Support\Facades\Auth;

class ChatController extends Controller
{
    public function fetchMessages()
    {
        return Message::with('user')->latest()->take(50)->get();
    }

    public function sendMessage(Request $request)
    {
        $request->validate([
            'text' => 'required|string'
        ]);

        $message = Message::create([
            'user_id' => Auth::id(),
            'text' => $request->text
        ]);

        return response()->json(['message' => $message->load('user')], 201);
    }
}
