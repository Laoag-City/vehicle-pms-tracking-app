<?php

namespace App\Http\Controllers;

use App\Http\Requests\AddNewVehicleRequest;
use App\Models\Vehicle;
use App\Services\OfficeService;
use App\Services\VehicleClassificationService;
use App\Services\VehicleMakeService;
use App\Services\VehicleService;
use App\Services\YearService;
use Illuminate\Http\Request;
use Illuminate\View\View;

class VehicleController extends Controller
{
    public function __construct(private VehicleService $vehicleService, 
                                private VehicleClassificationService $vehicleClassificationService, 
                                private VehicleMakeService $vehicleMakeService, 
                                private OfficeService $officeService,
                                private YearService $yearService)
    {

    }

    public function getVehicles(Request $request): View
    {
        if($request->user()->can('viewAny', Vehicle::class))
            $vehicles = $this->vehicleService->vehicles();

        else
            $vehicles = $this->vehicleService->vehicles($request->user()->office_id);

        return view('vehicles', [
            'vehicles' => $vehicles
        ]);
    }

    public function newVehicle(): View
    {
        $vehicleClassifications = $this->vehicleClassificationService->vehicleClassifications();
        $vehicleMakes = $this->vehicleMakeService->vehicleMakes();
        $offices = $this->officeService->offices();
        $yearNow = $this->yearService->getYear()->year;

        return view('new-vehicle', [
            'vehicleClassifications' => $vehicleClassifications,
            'vehicleMakes' => $vehicleMakes,
            'offices' => $offices,
            'yearNow' => $yearNow
        ]);
    }

    public function addNewVehicle(AddNewVehicleRequest $request)
    {
        $this->vehicleService->new($request->validated());

        return back()->with('success', 'New vehicle added successfully!');
    }
}
