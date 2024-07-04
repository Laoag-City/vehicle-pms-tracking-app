<?php

namespace App\Services;

use App\Models\RepairAndMaintenance;
use App\Models\Vehicle;

class RepairAndMaintenanceService
{
    public function new(Vehicle $vehicle, $validated)
    {
        $repairAndMaintenance = new RepairAndMaintenance;

        $repairAndMaintenance->vehicle_id = $vehicle->id;
        $repairAndMaintenance->component_id = $validated['component'];
        $repairAndMaintenance->description = $validated['description'];
        $repairAndMaintenance->is_repair = $repairAndMaintenance::$isRepairValues[$validated['type']];
        $repairAndMaintenance->estimated_cost = $validated['estimated_cost'];
        $repairAndMaintenance->date_encoded = $validated['date_encoded'];

        return $repairAndMaintenance->save();
    }
}
