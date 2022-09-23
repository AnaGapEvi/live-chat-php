<?php

namespace App\Http\Controllers;

use App\Events\CountMessage;
use App\Events\SendMessage;
use App\Models\Message;
use App\Models\User;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class MessageController extends Controller
{

    public function isRead(Request $request)
    {
        $user = User::find($request->userID);
        $messages = $user->messages()->where('receiverId', Auth::id())->where('isRead', 0)->get();

        for($i=0; $i<count($messages); $i++ ){
            $messages[$i]->isRead='1';
            $messages[$i]->save();
        }

        return response()->json(['message readed']);
    }


    public function unRead(int $id): JsonResponse
    {
        $user = User::find($id);
        $conut = $user->messages()->where('receiverId', Auth::id())->where('isRead', 0)->count();
        event(new CountMessage($conut));

       return  response()->json($conut);
    }

    // messages chat
    public function messages(int $id)
    {
       return Message::with('user')
            ->whereIn('receiverId',[Auth()->id(),$id ])
            ->whereIn('user_id', [$id,Auth()->id()])
            ->get();
    }

    // create new message
    public function messageStore(Request $request): JsonResponse
    {
        $user = Auth::user();
        $receiverId = $request->receiverId;
        $messages = Message::create([
            'receiverId'=> $request->receiverId,
            'message' =>$request->message,
            'user_id'=>Auth::user()->id,
        ]);

        event(new SendMessage($user, $messages, $receiverId));

        return response()->json(['message'=>'message sent'], );
    }
}
