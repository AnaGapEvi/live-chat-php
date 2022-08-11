<?php

namespace App\Http\Controllers;

use App\Events\NewTrade;
use App\Events\SendMessage;
use App\Models\Room;
use App\Models\User;
use App\Models\UserRoom;
use Illuminate\Http\Request;

class RoomController extends Controller
{
    public function rooms(){
        $rooms = Room::get();

        return response()->json($rooms);
    }

    public function  userRoom($id){
//        return Room::with('user')->where('room_id', $id)->get();
        $users = Room::where('id', $id)->with('users')->get();

        return response()->json($users);
    }
}
