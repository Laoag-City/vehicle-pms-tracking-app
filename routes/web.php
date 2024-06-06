<?php

use App\Http\Controllers\AuthenticationController;
use App\Http\Controllers\VehicleController;
use Illuminate\Support\Facades\Route;

Route::middleware('guest')->controller(AuthenticationController::class)->group(function(){
    Route::get('/login', 'showLogin')->name('login');
    Route::post('/login', 'authenticate');
});

Route::middleware('auth')->group(function() {
    Route::view('/', 'welcome')->name('home');

    Route::get('/vehicles', [VehicleController::class, 'getVehicles'])->name('vehicles');

    Route::get('/new-vehicle', [VehicleController::class, 'newVehicle'])
            ->middleware('can:create,App\Models\Vehicle')
            ->name('new_vehicle');

    Route::post('/logout', [AuthenticationController::class, 'logOut']);
});