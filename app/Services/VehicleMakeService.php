<?php

namespace App\Services;

use App\Models\VehicleMake;

class VehicleMakeService
{
    public function vehicleMakes()
    {
        return VehicleMake::all();
    }

    public function new($make): VehicleMake
    {
        $vehicleMake = new VehicleMake;
        $vehicleMake->make = $make;
        $vehicleMake->save();

        return $vehicleMake;
    }
}
