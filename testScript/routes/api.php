<?php

use App\Http\Controllers\Api\ApprovePresence;
use App\Http\Controllers\Api\Auth\LoginController;
use App\Http\Controllers\Api\Auth\LogoutController;
use App\Http\Controllers\Api\EpreseceController;
use App\Http\Controllers\Api\GetPresenceController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

Route::post('/login', [LoginController::class, '__invoke']);

Route::group(['middleware' => ['auth:sanctum']], function () {

    Route::get('/get-presences', [GetPresenceController::class, '__invoke']);
    Route::post('/insert-presence', [EpreseceController::class, '__invoke']);
    Route::patch('/approve-presence/{id}', [ApprovePresence::class, 'approvePresence']);

    Route::get('/get-user-presence', [ApprovePresence::class, 'getUserPresence']);
    Route::post('/logout', [LogoutController::class, '__invoke']);

});
