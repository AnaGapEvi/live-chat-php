<?php

namespace App\Http\Controllers;

use App\Events\NewTrade;
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
    }

    public function rooms(){
        $rooms = UserRoom::with('rooms')->get();
        return response()->json($rooms);
    }

    public function unRead($id){
        $user = User::find($id);
        $conut = $user->messages()->where('receiverId', Auth::id())->where('isRead', 0)->count();
       return  response()->json($conut);
    }

    public function messageStoreRoom(Request $request){
        $user = Auth::user();

        $roomId = $request->room_id;

        $messages = UserRoom::create([
            'room_id'=> $roomId,
            'message' =>$request->message,
            'user_id'=>Auth::user()->id,
        ]);

        event(new PrivateMessageEvent($user, $messages));
        event(new NewTrade($roomId));

        return'message sent';
    }
}
