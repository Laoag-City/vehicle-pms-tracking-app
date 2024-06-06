<?php

namespace App\Services;

use App\Models\VehicleMake;

class VehicleMakeService
{
    public function vehicleMakes()
    {
        return VehicleMake::all();
    }
}
