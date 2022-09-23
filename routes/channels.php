<?php

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Broadcast;


Broadcast::channel('App.Models.User.{id}', function ($user, $id) {
    return (int) $user->id === (int) $id;
});


Broadcast::channel('chat', function (){
    return true;
});

Broadcast::channel('count-message', function (){
    return true;
});


Broadcast::channel('chat-channel', function (){
    return Auth::check();
});

Broadcast::channel('chat-room-channel', function (){
    return Auth::check();
});


Broadcast::routes(['middleware' => ['auth:api']]);
