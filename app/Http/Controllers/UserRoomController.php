<?php

namespace App\Http\Controllers;

use App\Events\NewTrade;
use App\Events\PrivateMessageEvent;
use App\Models\User;
use App\Models\UserRoom;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class UserRoomController extends Controller
{
    // return users by rooms
    public function room(int $id)
    {
        return UserRoom::where('room_id', $id)->with('user')->get();
    }

    // return count unread message
    public function unRead(int $id)
    {
        $user = User::find($id);
        $conut = $user->messages()->where('receiverId', Auth::id())->where('isRead', 0)->count();
       return  response()->json($conut);
    }

    // create new message in room
    public function messageStoreRoom(Request $request): JsonResponse
    {
        $user = Auth::user();
        $roomId = $request->room_id;
        $messages = UserRoom::create([
            'room_id'=> $roomId,
            'message' =>$request->message,
            'user_id'=>Auth::user()->id,
        ]);
        event(new PrivateMessageEvent($user, $messages));
        event(new NewTrade($roomId));

        return response()->json(['message' => 'message sent']);
    }
}
