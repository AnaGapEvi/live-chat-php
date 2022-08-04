<?php

namespace App\Http\Controllers;

use App\Events\PrivateMessageEvent;
use App\Events\SendMessage;
use App\Models\Message;
use App\Models\Room;
use App\Models\User;
use App\Models\UserRoom;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class UserRoomController extends Controller
{
    public function room($id){


        return UserRoom::where('room_id', $id)->with('user')->get();
//        return UserRoom::whit('users')->where('room_id', $id)->get();

    }
//    public function  userRoom($id){
//        return Room::where('room_id', $id)->with('user')->get();
//    }

    public function messageStoreRoom(Request $request){
        $user = Auth::user();

        $roomId = $request->room_id;

        $messages = UserRoom::create([
            'room_id'=> $request->room_id,
            'message' =>$request->message,
            'user_id'=>Auth::user()->id,
        ]);



        event(new PrivateMessageEvent($user, $messages));

        return'message sent';
    }
}
