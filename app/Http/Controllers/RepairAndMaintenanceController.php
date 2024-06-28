<?php

namespace App\Http\Controllers;

use App\Http\Requests\AddRepairAndMaintenanceRequest;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class RepairAndMaintenanceController extends Controller
{
    public function newRepairAndMaintenance(Request $request): View
    {
        return view('new-repair-maintenance');
    }

    public function addNewRepairAndMaintenance(AddRepairAndMaintenanceRequest $request): RedirectResponse
    {
        return back();
    }
}
