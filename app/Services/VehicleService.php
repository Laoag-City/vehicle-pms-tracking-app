<?php

namespace App\Services;

use App\Models\Vehicle;

class VehicleService
{
    public function vehicles($officeId = null, $classificationId = null, $makeId = null)
    {
        $vehicles = Vehicle::query();

        if($officeId != null)
            $vehicles = $vehicles->where('office_id', $officeId);

        if($classificationId != null)
            $vehicles = $vehicles->where('vehicle_classification_id', $classificationId);

        if($makeId != null)
            $vehicles = $vehicles->where('vehicle_make_id', $makeId);

        return $vehicles->get();
    }

    public function new($validatedData)
    {
        $vehicle = new Vehicle;
    }
}
