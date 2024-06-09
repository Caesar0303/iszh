<?php

namespace App\Models;

use Orchid\Platform\Models\User as Authenticatable;

class User extends Authenticatable
{
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name',
        'email',
        'password',
        'permissions',
    ];

    /**
     * The attributes excluded from the model's JSON form.
     *
     * @var array
     */
    protected $hidden = [
        'password',
        'remember_token',
        'permissions',
    ];

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
        'permissions'          => 'array',
        'email_verified_at'    => 'datetime',
    ];

    /**
     * The attributes for which you can use filters in url.
     *
     * @var array
     */
    protected $allowedFilters = [
        'id',
        'name',
        'email',
        'permissions',
    ];

    /**
     * The attributes for which can use sort in url.
     *
     * @var array
     */
    protected $allowedSorts = [
        'id',
        'name',
        'email',
        'updated_at',
        'created_at',
    ];


    public function getContactedUsersWithUnreadMessages()
    {
        $user_id = $this->id;

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

            // Используем метод модели для получения количества непрочитанных сообщений
            $unread_messages_count = Message::getUnreadMessagesCount($contact_id, $user_id);

            // Добавляем информацию о контакте и количестве непрочитанных сообщений в массив
            $contacted_users[] = [
                'contact' => $contact,
                'unread_messages_count' => $unread_messages_count
            ];
        }

        return $contacted_users;
    }
}
