<?php

use App\Http\Controllers\MessageController;
use App\Http\Controllers\RoomController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\UserRoomController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Broadcast;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

Route::post('/register', [UserController::class, 'register']);
Route::post('/login', [UserController::class, 'login']);
Route::put('/forgot', [UserController::class, 'forgotPassword']);

Route::middleware('auth:api')->group(function () {
    Broadcast::routes();
    Route::get('/me', [UserController::class, 'me']);
    Route::get('/us{$id}', [UserController::class, 'user']);
    Route::get('/users', [UserController::class, 'users']);
    Route::get('/logout', [UserController::class, 'logout']);
    Route::get('/rooms', [RoomController::class, 'rooms']);
    Route::get('/messages/{id}', [MessageController::class, 'messages'])->name('messages');
    Route::post('/messages', [MessageController::class, 'messageStore'])->name('messageStore');

    Route::get('/status/user-message/{id}', [MessageController::class, 'unRead'])->name('un-read');
    Route::put('/status/message-read', [MessageController::class, 'isRead'])->name('is-read');

    Route::get('/room-messages/{id}', [UserRoomController::class, 'room'])->name('room-message');
    Route::post('/room-messages', [UserRoomController::class, 'messageStoreRoom'])->name('room-message-store');
    Route::get('/user-room/{id}', [RoomController::class, 'userRoom'])->name('room-user');
    Route::get('/status/user-room-message/{id}', [UserRoomController::class, 'unRead'])->name('un-read-group');
    Route::put('/status/room-message-read', [UserRoomController::class, 'isRead'])->name('is-read-group');

});



