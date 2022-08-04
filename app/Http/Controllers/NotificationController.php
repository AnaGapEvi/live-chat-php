<?php

namespace App\Http\Controllers;

use App\Models\Message;
use App\Models\User;
use App\Notifications\NewMessage;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Notification;

class NotificationController extends Controller
{
    public function __construct()
     {
     $this->middleware('auth');
     }

     public function index($id)
     {
     // пользователь 2 отправляет уведомление пользователю 1
     $message = new Message;
     $message->setAttribute('user_id', Auth::id());
     $message->setAttribute('receiverId', $id);
     $message->setAttribute('message', 'Demo message from user auth to user receiver.');
     $message->save();

     $fromUser = User::find('user_id');
     $toUser = User::find('receiverId');

     // отправляем уведомление с помощью модели "user", когда пользователь получил новое сообщение
     $toUser->notify(new NewMessage($fromUser));

     // отправляем уведомление с помощью фасада "Notification"
     Notification::send($toUser, new NewMessage($fromUser));
     }
}
