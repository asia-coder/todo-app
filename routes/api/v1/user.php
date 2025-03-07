<?php

use App\Http\Controllers\V1\User\LoginController;
use App\Http\Controllers\V1\User\LogoutController;
use App\Http\Controllers\V1\User\RegisterController;
use App\Http\Controllers\V1\User\UserController;
use Illuminate\Support\Facades\Route;

Route::middleware(['auth:sanctum'])->group(function () {
    Route::get('/', UserController::class)->name('profile');
    Route::post('/logout', LogoutController::class)->name('logout');
});

Route::post('/register', RegisterController::class)->name('register');
Route::post('/login', LoginController::class)->name('login');
