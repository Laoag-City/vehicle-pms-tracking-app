<?php

use App\Http\Controllers\AuthenticationController;
use Illuminate\Support\Facades\Route;

Route::middleware('guest')->controller(AuthenticationController::class)->group(function(){
    Route::get('/login', 'showLogin')->name('login');
    Route::post('/login', 'authenticate');
});

Route::middleware('auth')->group(function() {
    Route::view('/', 'welcome')->name('home');

    

    Route::post('/logout', [AuthenticationController::class, 'logOut']);
});