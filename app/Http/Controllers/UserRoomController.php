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
    }




    public function rooms(){
        $rooms = UserRoom::with('rooms')->get();
        return response()->json($rooms);
    }



//    public function isRead(Request $request){
//
//        $messages = UserRoom::where('room_id', $request->roomID)
//            ->where('user_id', Auth::id())
//            ->where('isRead', 0)
//            ->get();
//
//         for($i=0; $i<count($messages); $i++ ){
//            $messages[$i]->isRead='1';
//            $messages[$i]->save();
//        }
//        return 'message readed';
//    }



    public function unRead($id){
        $user = User::find($id);
        $conut = $user->messages()->where('receiverId', Auth::id())->where('isRead', 0)->count();
       return  response()->json($conut);
    }



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
