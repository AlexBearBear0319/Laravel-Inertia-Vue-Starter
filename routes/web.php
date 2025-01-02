<?php

use App\Http\Controllers\Auth\RegisterController;
use Illuminate\Support\Facades\Route;

Route::inertia('/', 'Home')->name('home');

Route::inertia('/dashboard', 'Dashboard')->middleware(['auth', 'verified'])->name('dashboard');

Route::inertia('/profile', 'Profile/Edit')->middleware(['auth'])->name('profile.edit');

require __DIR__ . '/auth.php';
