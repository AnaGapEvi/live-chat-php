<?php

namespace App\Http\Controllers;

use App\Models\Room;
use Illuminate\Http\JsonResponse;

class RoomController extends Controller
{
    public function rooms(): JsonResponse
    {
        $rooms = Room::get();

        return response()->json($rooms);
    }

    public function  userRoom(int $id): JsonResponse
    {
        $users = Room::where('id', $id)->with('users')->get();

        return response()->json($users);
    }
}
