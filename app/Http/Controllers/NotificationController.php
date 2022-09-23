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
    //create new message
//     public function index(int $id)
//     {
//         $message = new Message;
//         $message->setAttribute('user_id', Auth::id());
//         $message->setAttribute('receiverId', $id);
//         $message->setAttribute('message', 'Demo message from user auth to user receiver.');
//         $message->save();
//
//         $fromUser = User::find('user_id');
//         $toUser = User::find('receiverId');
//
//         $toUser->notify(new NewMessage($fromUser));
//
//         Notification::send($toUser, new NewMessage($fromUser));
//     }
}
