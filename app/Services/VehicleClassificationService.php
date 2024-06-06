<?php

namespace App\Services;

use App\Models\VehicleClassification;

class VehicleClassificationService
{
    public function vehicleClassifications()
    {
        return VehicleClassification::all();
    }
}
