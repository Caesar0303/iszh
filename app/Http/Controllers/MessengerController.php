<?php

namespace App\Http\Controllers;

use App\Models\Message;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Inertia\Inertia;

class MessengerController extends Controller
{
    public function getUncheckedMessagesCount()
    {
        $user_id = Auth::id();
        $unchecked_messages_count = Message::where('receiver_id', $user_id)
            ->where('read', 0)
            ->count();

        return $unchecked_messages_count;
    }
    public function list()
    {
        $user_id = Auth::id();

        // Получаем все сообщения пользователя
        $messages = Message::where('sender_id', $user_id)
            ->orWhere('receiver_id', $user_id)
            ->get();

        // Получаем список уникальных идентификаторов пользователей, с которыми были контакты
        $contacted_users_ids = $messages->pluck('sender_id')->merge($messages->pluck('receiver_id'))->unique();

        // Исключаем идентификатор текущего пользователя из списка контактов
        $contacted_users_ids = $contacted_users_ids->reject(function ($userId) use ($user_id) {
            return $userId == $user_id;
        });

        // Для каждого контакта получаем непрочитанные сообщения
        $contacted_users = [];
        foreach ($contacted_users_ids as $contact_id) {
            $contact = User::find($contact_id);

            // Проверка, найден ли пользователь
            if ($contact) {
                // Находим непрочитанные сообщения для данного контакта
                $unread_messages_count = Message::where('sender_id', $contact_id)
                    ->where('receiver_id', $user_id)
                    ->where('read', 0)
                    ->count();

                // Добавляем информацию о контакте и количестве непрочитанных сообщений в массив
                $contacted_users[] = [
                    'contact' => $contact,
                    'unread_messages_count' => $unread_messages_count
                ];
            }
        }
        return $contacted_users;
    }
    public function sendMessage($id) {
        $sender_id = Auth::id();
        $receiver_id = $id;

        Message::where('sender_id', $receiver_id)
            ->where('receiver_id', $sender_id)
            ->where('read', 0)
            ->update(['read' => 1]);

        $receiver = User::find($receiver_id);
        $messages = Message::where(function ($query) use ($sender_id, $receiver_id) {
            $query->where('sender_id', $sender_id)
                ->where('receiver_id', $receiver_id);
        })
            ->orWhere(function ($query) use ($sender_id, $receiver_id) {
                $query->where('sender_id', $receiver_id)
                    ->where('receiver_id', $sender_id);
            })
            ->get()
            ->sortBy('id');

        return Inertia::render('Messenger/List', [
            'messages' => $messages,
            'receiver' => $receiver,
            'sender_id' => $sender_id
        ]);
    }

    public function sendMessageTo($id) {
        $sender_id = Auth::id();
        $receiver_id = $id;

        Message::create([
            'sender_id' => $sender_id,
            'receiver_id' => $receiver_id,
            'text' => \request()->newmessage,
        ]);

        $messages = Message::where(function ($query) use ($sender_id, $receiver_id) {
            $query->where('sender_id', $sender_id)
                ->where('receiver_id', $receiver_id);
        })
            ->orWhere(function ($query) use ($sender_id, $receiver_id) {
                $query->where('sender_id', $receiver_id)
                    ->where('receiver_id', $sender_id);
            })
            ->get()
            ->sortBy('id');

        return $messages;
    }
}
