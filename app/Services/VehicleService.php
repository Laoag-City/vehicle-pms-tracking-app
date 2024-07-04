<?php

namespace App\Services;

use App\Models\Vehicle;

class VehicleService
{
    public function __construct(private YearService $yearService, private VehicleMakeService $vehicleMakeService)
    {
        
    }

    public function vehicles($officeId = null, $classificationId = null, $makeId = null)
    {
        $vehicles = Vehicle::query();

        if($officeId != null)
            $vehicles = $vehicles->where('office_id', $officeId);

        if($classificationId != null)
            $vehicles = $vehicles->where('vehicle_classification_id', $classificationId);

        if($makeId != null)
            $vehicles = $vehicles->where('vehicle_make_id', $makeId);

        return $vehicles->with(['office', 'vehicleClassification', 'repairAndMaintenances', 'vehicleMake', 'year'])
                        ->get();
    }
    
    public function new($validatedData): bool
    {
        $year = $this->yearService->getYear($validatedData['year_model']);

        if((bool)$validatedData['show_make_list'])
            $vehicle_make = $validatedData['vehicle_make'];
        else
            $vehicle_make = $this->vehicleMakeService->new($validatedData['new_vehicle_make'])->id;

        $vehicle = new Vehicle;

        $vehicle->office_id = $validatedData['office_issued_to'];
        $vehicle->vehicle_classification_id = $validatedData['vehicle_classification'];
        $vehicle->vehicle_make_id = $vehicle_make;
        $vehicle->year_id = $year->id;
        $vehicle->model = $validatedData['model'];
        $vehicle->plate_number = $validatedData['plate_number'];

        return $vehicle->save();
    }


    public function edit(Vehicle $vehicle, $validatedData): bool
    {
        //strike two of the Rule-of-three in programming. A third duplication means it's time for abstraction

        $year = $this->yearService->getYear($validatedData['year_model']);

        if((bool)$validatedData['show_make_list'])
            $vehicle_make = $validatedData['vehicle_make'];
        else
            $vehicle_make = $this->vehicleMakeService->new($validatedData['new_vehicle_make'])->id;

        $vehicle->office_id = $validatedData['office_issued_to'];
        $vehicle->vehicle_classification_id = $validatedData['vehicle_classification'];
        $vehicle->vehicle_make_id = $vehicle_make;
        $vehicle->year_id = $year->id;
        $vehicle->model = $validatedData['model'];
        $vehicle->plate_number = $validatedData['plate_number'];

        return $vehicle->save();
    }

    public function loadOtherVehicleInfo(Vehicle $vehicle): Vehicle
    {
        return $vehicle->load('office', 'vehicleClassification', 'repairAndMaintenances.component', 'vehicleMake', 'year');
    }
}
