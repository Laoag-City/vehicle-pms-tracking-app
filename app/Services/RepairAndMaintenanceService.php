<?php

namespace App\Services;

use App\Models\RepairAndMaintenance;
use App\Models\Vehicle;

class RepairAndMaintenanceService
{
    public function new(Vehicle $vehicle, $validated)
    {
        foreach($validated['record'] as $item)
        {
            $repairAndMaintenance = new RepairAndMaintenance;

            $repairAndMaintenance->vehicle_id = $vehicle->id;
            $repairAndMaintenance->component_id = $item['component'];
            $repairAndMaintenance->description = $item['description'];
            $repairAndMaintenance->is_repair = $repairAndMaintenance::$isRepairValues[$item['type']];
            $repairAndMaintenance->estimated_cost = $item['estimated_cost'];
            $repairAndMaintenance->date_encoded = $validated['date_encoded'];

            $repairAndMaintenance->save();
        }

        return true;
    }

    public function edit(RepairAndMaintenance $repairAndMaintenance, $validated)
    {
        $repairAndMaintenance->component_id = $validated['component'];
        $repairAndMaintenance->description = $validated['description'];
        $repairAndMaintenance->is_repair = $repairAndMaintenance::$isRepairValues[$validated['type']];
        $repairAndMaintenance->estimated_cost = $validated['estimated_cost'];
        $repairAndMaintenance->date_encoded = $validated['date_encoded'];

        return $repairAndMaintenance->save();
    }

    public function getPaginatedRecords(Vehicle $vehicle, $perPage)
    {
        return RepairAndMaintenance::where('vehicle_id', $vehicle->id)
                                    ->orderBy('date_encoded', 'desc')
                                    ->paginate($perPage);
    }

    public function delete(RepairAndMaintenance $repairAndMaintenance): bool
    {
        return $repairAndMaintenance->delete(); 
    }
}
