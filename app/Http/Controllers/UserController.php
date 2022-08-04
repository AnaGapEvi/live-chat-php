<?php

namespace App\Http\Controllers;

use App\Models\User;
use Carbon\Carbon;
use Illuminate\Auth\Events\Validated;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Http\Request;
use Illuminate\Notifications\Notifiable;
use Illuminate\Support\Facades\Hash;
use Laravel\Passport\HasApiTokens;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Mail;
//use Illuminate\Foundation\Auth\SendsPasswordResetEmails;
//use Illuminate\Foundation\Auth\ResetsPasswords;

class UserController extends Controller
{

    use HasApiTokens, HasFactory, Notifiable;
    public function users(){
        return User::where('id', '!=', Auth::id())->get();
//        return response()->json($users);
    }

    public function register(Request $request)
    {
        $validator = $request->validate([

            'name'=>'required',
            'surname'=>'required',
            'email'=>'required|email',
            'gender'=>'required',
            'password' => 'required|min:8',
        ]);
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

    public function login(Request $request)
    {
        $validator = $request->validate([
            'email'=>'required|email',
            'password' => 'required',
        ]);
        if($validator){
            $user = User::query()->where('email', $request->email,)->first();

            if($user) {
                if (Hash::check($request->password, $user->password)) {
                    $user->status="active";
                    $user->save();
                    $token = $user->createToken('Laravel Password Grant Client')->accessToken;
                    $response = ['token' => $token];

                    return response($response);
                } else {
                    $response = ["message" => "Password mismatch"];
                    return response($response, 422);
                }
            } else {
                $response = ["message" =>'User does not exist'];
                return response($response, 422);
            }
        } else{
            return response()->json($validator->erroe());
        }

    }
    public function user($id){
        $user = User::find($id)->get();

        return $user;

    }

    public function me()
    {
        return response()->json(['user' => auth()->user()]);
    }

    public function forgotPassword(Request $request){
        $user = User::query()->where('email', $request->email,)->first();
        $user->password = '';
        if($request->password){
            $user->password = Hash::make($request->password);
        }
        $user->save();
        return response()->json($user);
    }

    public function logout(Request $request)
    {   $user= Auth::user();
        $request->user()->token()->revoke();
        $user->status='off';
        $user->save();

        return response()->json([
            'message' => 'Successfully logged out'
        ]);
    }
}
