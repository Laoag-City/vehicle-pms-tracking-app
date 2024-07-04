<?php

use App\Http\Controllers\AuthenticationController;
use App\Http\Controllers\RepairAndMaintenanceController;
use App\Http\Controllers\VehicleController;
use Illuminate\Support\Facades\Route;

Route::middleware('guest')->controller(AuthenticationController::class)->group(function(){
    Route::get('/login', 'showLogin')->name('login');
    Route::post('/login', 'authenticate');
});

Route::middleware('auth')->group(function() {
    Route::view('/', 'welcome')->name('home');

    Route::get('/vehicles', [VehicleController::class, 'getVehicles'])->name('vehicles');

    Route::get('/vehicles/{vehicle}', [VehicleController::class, 'vehicleInfo'])->name('vehicle_info');

    Route::put('/vehicles/{vehicle}', [VehicleController::class, 'updateVehicle'])
        ->middleware('can:update,vehicle')
        ->name('update_vehicle');

    Route::middleware('can:update,App\Models\RepairAndMaintenance')->group(function(){
        Route::get('/vehicles/{vehicle}/repair-maintenance/{repairAndMaintenance}', [RepairAndMaintenanceController::class, 'repairAndMaintenanceInfo'])
            ->scopeBindings()
            ->name('repair_and_maintenance_info');

        Route::put('/vehicles/{vehicle}/repair-maintenance/{repair_and_maintenance}', [RepairAndMaintenanceController::class, 'updateRepairAndMaintenance'])
            ->scopeBindings()
            ->name('update_repair_and_maintenance');
    });

    Route::middleware('can:create,App\Models\Vehicle')->group(function(){
        Route::get('/new-vehicle', [VehicleController::class, 'newVehicle'])
            ->name('new_vehicle');

        Route::post('/new-vehicle', [VehicleController::class, 'addNewVehicle'])
            ->name('add_new_vehicle');
    });

    Route::middleware('can:create,App\Models\RepairAndMaintenance')->group(function(){
        Route::get('/new-repair-maintenance/{vehicle}', [RepairAndMaintenanceController::class, 'newRepairAndMaintenance'])
            ->name('new_repair_and_maintenance');

        Route::post('/new-repair-maintenance/{vehicle}', [RepairAndMaintenanceController::class, 'addNewRepairAndMaintenance'])
            ->name('add_new_repair_and_maintenance');
    });

    Route::post('/logout', [AuthenticationController::class, 'logOut']);
});