<?php

use App\Http\Controllers\API\AuthController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

Route::get('/user', function (Request $request) {
    return $request->user();
})->middleware('auth:sanctum');


Route::group(['prefix' => 'auth'], function () {
    Route::controller(AuthController::class)->group(function () {
        Route::post('/fcm-token', 'saveFcmToken')->name('create.fcm.token')->middleware('auth:sanctum');
        Route::post('/register', 'register');
        Route::post('/login', 'login');
        Route::post('/logout', 'logout')->middleware('auth:sanctum');
        Route::get('/user', 'user')->middleware('auth:sanctum');
    });

   // Route::post('/profile', [ProfileController::class, 'updateProfile'])->middleware('auth:sanctum');
   // Route::get('/notifications/{id}', [ProfileController::class, 'notificationSettings'])->middleware('auth:sanctum');
   // Route::post('/delete-account', [ProfileController::class, 'deleteProfile'])->middleware('auth:sanctum');
});
