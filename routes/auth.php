<?php

use App\Http\Controllers\Auth\AuthenticateController;
use App\Http\Controllers\Auth\RegisterController;
use App\Http\Controllers\Auth\ResetPasswordController;
use Illuminate\Support\Facades\Route;

//for Guest
Route::middleware('guest')->group(function () {

    // Register
    Route::get('/register', [RegisterController::class, 'create'])->name('register');
    Route::post('/register', [RegisterController::class, 'store']);

    // Login
    Route::get('/login', [AuthenticateController::class, 'create'])->name('login');
    Route::post('/login', [AuthenticateController::class, 'store']);

    //Reset Password
    Route::get('/forgot-password', [ResetPasswordController::class, 'resetPass'])->name('password.request');
    Route::post(
        '/forgot-password',
        [ResetPasswordController::class, 'sendEmail']
    )->name('password.email');
});

//for Auth/User
Route::middleware('auth')->group(function () {
    //Logout
    Route::post('/logout', [AuthenticateController::class, 'destroy'])->name('logout');
});
