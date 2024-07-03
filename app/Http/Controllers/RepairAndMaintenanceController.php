<?php

namespace App\Http\Controllers;

use App\Http\Requests\AddRepairAndMaintenanceRequest;
use App\Models\Vehicle;
use App\Services\ComponentService;
use App\Services\RepairAndMaintenanceService;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class RepairAndMaintenanceController extends Controller
{
    public function __construct(private RepairAndMaintenanceService $repairAndMaintenanceService, private ComponentService $componentService)
    {

    }

    public function newRepairAndMaintenance(Vehicle $vehicle): View
    {
        $components = $this->componentService->components();

        return view('new-repair-maintenance', [
            'vehicle' => $vehicle,
            'components' => $components
        ]);
    }

    public function addNewRepairAndMaintenance(Vehicle $vehicle, AddRepairAndMaintenanceRequest $request): RedirectResponse
    {
        $added = $this->repairAndMaintenanceService->new($vehicle, $request->validated());

        abort_if(!$added, 500);

        return back()->with('success', 'New Repair/Maintenance record added successfully!');
    }
}
