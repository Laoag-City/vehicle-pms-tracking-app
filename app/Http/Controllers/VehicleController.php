<?php

namespace App\Http\Controllers;

use App\Models\Vehicle;
use Illuminate\Http\Request;
use Illuminate\View\View;

class VehicleController extends Controller
{
    public function getVehicles(Request $request): View
    {
        $vehicles = Vehicle::where('office_id', $request->user()->office_id)->get();

        return view();
    }
}
