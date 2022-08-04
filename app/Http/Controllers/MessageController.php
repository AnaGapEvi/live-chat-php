<?php

namespace App\Http\Controllers;

use App\Events\NewTrade;
use App\Events\SendMessage;
use App\Models\Message;
use App\Models\User;
use App\Notifications\NewMessage;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Notification;

class MessageController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function isRead(Request $request){

        $user = User::find($request->userID);
        $messages = $user->messages()->where('receiverId', Auth::id())->where('isRead', 0)->get();

        for($i=0; $i<count($messages); $i++ ){
            $messages[$i]->isRead='1';
            $messages[$i]->save();
        }
        return 'message readed';
    }

    public function unRead($id){

        $user = User::find($id);
        $conut = $user->messages()->where('receiverId', Auth::id())->where('isRead', 0)->count();
       return  response()->json($conut);
    }

    public function messages($id){

       return Message::with('user')
            ->whereIn('receiverId',[Auth()->id(),$id ])
            ->whereIn('user_id', [$id,Auth()->id()])
            ->get();
    }

    public function messageStore(Request $request){
        $user = Auth::user();
        $receiverId = $request->receiverId;
        $messages = Message::create([
            'receiverId'=> $request->receiverId,
            'message' =>$request->message,
            'user_id'=>Auth::user()->id,
        ]);

////Notification
//        $fromUser = User::find('user_id');
//        $toUser = User::find('receiverId');
//        $toUser->notify(new NewMessage($fromUser));
//        Notification::send($toUser, new NewMessage($fromUser));

////laravel-echo
        event(new SendMessage($user, $messages, $receiverId));

        return'message sent';
    }
}
