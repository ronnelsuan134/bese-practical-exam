<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\Auth\GuestLoginController;
use App\Http\Controllers\Api\Order\OrderController;


Route::post('/register', [GuestLoginController::class, 'register'])->name('guest.register');
Route::post('/login', [GuestLoginController::class, 'login'])->name('guest.login');
Route::post('/logout', [GuestLoginController::class, 'logout'])->name('guest.logout');
Route::get('/activate/{id}', [GuestLoginController::class, 'activateGuest'])->name('guest.activate');


Route::group(['prefix' => '/order','middleware' => 'auth:api_guest_user'], function(){
    Route::post('/store', [OrderController::class, 'store']);
});
