<?php

namespace App\Http\Controllers;

use App\Http\Requests\AddRepairAndMaintenanceRequest;
use App\Models\Vehicle;
use App\Services\ComponentService;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class RepairAndMaintenanceController extends Controller
{
    public function __construct(private ComponentService $componentService)
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

    public function addNewRepairAndMaintenance(AddRepairAndMaintenanceRequest $request): RedirectResponse
    {
        return back();
    }
}
