<?php

namespace App\Http\Controllers;

use App\Http\Requests\AddRepairAndMaintenanceRequest;
use App\Http\Requests\EditRepairAndMaintenanceInfoRequest;
use App\Http\Requests\OfficeFilterRequest;
use App\Models\RepairAndMaintenance;
use App\Models\Vehicle;
use App\Services\ComponentService;
use App\Services\OfficeService;
use App\Services\RepairAndMaintenanceService;
use App\Services\VehicleService;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class RepairAndMaintenanceController extends Controller
{
    public function __construct(private RepairAndMaintenanceService $repairAndMaintenanceService, private ComponentService $componentService)
    {

    }

    public function getRepairAndMaintenances(Request $request, OfficeService $officeService, VehicleService $vehicleService): View
    {
        //codes below are similar to VehicleController's getVehicles()
        $offices = collect();
        $vehicles = collect();
        $canViewAnyVehicle = $request->user()->can('viewAny', Vehicle::class);

        if($canViewAnyVehicle)
        {
            $offices = $officeService->offices()->sortBy('name');

            if($request->office_filter != null)
            {
                app(OfficeFilterRequest::class);

                $office = $offices->where('id', $request->office_filter)->first();

                $vehicles = $vehicleService->vehicles($office->id);
            }
        }

        else
            $vehicles = $vehicleService->vehicles($request->user()->office_id);

        return view('repairs-maintenances', [
            'canViewAnyVehicle' => $canViewAnyVehicle,
            'offices' => $offices,
            'vehicles' => $vehicles
        ]);
    }

    public function newRepairAndMaintenance(Vehicle $vehicle): View
    {
        $components = $this->componentService->components()->sortBy('component');

        return view('new-repair-maintenance', [
            'vehicle' => $vehicle,
            'components' => $components,
            'isRepairValues' => array_keys(RepairAndMaintenance::$isRepairValues)
        ]);
    }

    public function addNewRepairAndMaintenance(Vehicle $vehicle, AddRepairAndMaintenanceRequest $request): RedirectResponse
    {
        $added = $this->repairAndMaintenanceService->new($vehicle, $request->validated());

        abort_if(!$added, 500);

        return back()->with('success', 'New record added successfully!');
    }

    public function repairAndMaintenanceInfo(Vehicle $vehicle, RepairAndMaintenance $repairAndMaintenance): View
    {
        $components = $this->componentService->components()->sortBy('component');

        return view('edit-repair-maintenance', [
            'vehicle' => $vehicle,
            'components' => $components,
            'repairAndMaintenance' => $repairAndMaintenance,
            'isRepairValues' => array_keys(RepairAndMaintenance::$isRepairValues)
        ]);
    }

    public function updateRepairAndMaintenance(Vehicle $vehicle, RepairAndMaintenance $repairAndMaintenance, EditRepairAndMaintenanceInfoRequest $request): RedirectResponse
    {
        $updated = $this->repairAndMaintenanceService->edit($repairAndMaintenance, $request->validated());

        abort_if(!$updated, 500);

        return back()->with('success', 'Repair/Maintenance record updated successfully!');
    }

    public function deleteRepairAndMaintenance(Vehicle $vehicle, RepairAndMaintenance $repairAndMaintenance): RedirectResponse
    {
        $deleted = $this->repairAndMaintenanceService->delete($repairAndMaintenance);

        abort_if(!$deleted, 500);

        return redirect(route('vehicle_info', ['vehicle' => $vehicle->id]));
    }
}
