<?php

namespace App\Http\Controllers;

use App\Models\Message;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Inertia\Inertia;

class MessengerController extends Controller
{
    public function sendMessage($id) {
        $sender_id = Auth::id();
        $receiver_id = $id;

        $receiver = User::find($receiver_id);

        $messagesSent = Message::where('sender_id', $sender_id)
            ->where('receiver_id', $receiver_id)
            ->get();

        $messagesReceived = Message::where('sender_id', $receiver_id)
            ->where('receiver_id', $sender_id)
            ->get();

        $messages = $messagesSent->merge($messagesReceived)->sortBy('created_at');

        return Inertia::render('Messenger/List', [
            'messages' => $messages,
            'receiver' => $receiver,
            'sender_id' => $sender_id
        ]);
    }
}
