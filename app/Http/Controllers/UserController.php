<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Notifications\Notifiable;
use Illuminate\Support\Facades\Hash;
use Laravel\Passport\HasApiTokens;
use Illuminate\Support\Facades\Auth;

class UserController extends Controller
{
    use HasApiTokens, HasFactory, Notifiable;

    public function users(): JsonResponse
    {
        $user = User::where('id', '!=', Auth::id())->get();
        return response()->json($user);
    }

    //registration
    public function register(Request $request): JsonResponse
    {
        $validator = $request->validate([
            'name'=>'required',
            'surname'=>'required',
            'email'=>'required|email',
            'gender'=>'required',
            'password' => 'required|min:8',
        ]);

        if (!$validator) {
            return response()->json($validator->erroe());
        }

        $user = new User();
        $user->name=$request->name;
        $user->surname=$request->surname;
        $user->email=$request->email;
        $user->gender=$request->gender;
        $user->password = Hash::make($request->password);
        $user->save();
        $token = $user->createToken('Laravel')->accessToken;
        $user->reg_token = $token;

        return response()->json(['token' => $token], 200);
    }

    public function login(Request $request): JsonResponse
    {
        $validator = $request->validate([
            'email'=>'required|email',
            'password' => 'required',
        ]);

        if (!$validator) {
            return response()->json($validator->error());
        }

        $user = User::query()->where('email', $request->email)->first();
        $hash = Hash::check($request->password, $user->password);

        if (!$user || !$hash) {
            $response = ['message' => 'Email Or Password Is Incorrect'];
            return response()->json($response, 422);
        }

        $user->status = "active";
        $user->save();
        $token = $user->createToken('Laravel Password Grant Client')->accessToken;
        $response = ['token' => $token];

        return response()->json($response);
    }

    // search user by id
    public function user(int $id): JsonResponse
    {
        $user = User::find($id)->get();
        dd($user);

        return response()->json($user);
    }

    // return auth user
    public function me(): JsonResponse
    {
        return response()->json(['user' => auth()->user()]);
    }

    // forgot Password
    public function forgotPassword(Request $request): JsonResponse
    {
        $user = User::query()->where('email', $request->email)->first();

        if (!$user) {
            return response()->json(['message'=>"user does not exist"]);
        }

        $user->password = '';

        if ($request->password) {
            $user->password = Hash::make($request->password);
        }

        $user->save();
        return response()->json($user);
    }

    //log out
    public function logout(Request $request): JsonResponse
    {
        $user = Auth::user();
        $request->user()->token()->revoke();
        $user->status = 'off';
        $user->save();

        return response()->json([
            'message' => 'Successfully logged out'
        ]);
    }
}
