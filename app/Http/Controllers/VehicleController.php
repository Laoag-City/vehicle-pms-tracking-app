<?php

namespace App\Http\Controllers;

use App\Http\Requests\AddNewVehicleRequest;
use App\Http\Requests\EditVehicleInfoRequest;
use App\Models\Vehicle;
use App\Services\OfficeService;
use App\Services\VehicleClassificationService;
use App\Services\VehicleMakeService;
use App\Services\VehicleService;
use App\Services\YearService;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\Validator;
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
        $offices = [];
        $canViewAnyVehicle = $request->user()->can('viewAny', Vehicle::class);

        if($canViewAnyVehicle)
        {
            $offices = $this->officeService->offices();

            if(!$request->office_filter)
                $vehicles = $this->vehicleService->vehicles();

            else
            {
                Validator::make($request->all(), [
                    'office_filter' => 'required|exists:offices,id'
                ])->validate();

                $office = $offices->where('id', $request->office_filter)->first();

                $vehicles = $this->vehicleService->vehicles($office->id);
            }
        }

        else
            $vehicles = $this->vehicleService->vehicles($request->user()->office_id);

        return view('vehicles', [
            'canViewAnyVehicle' => $canViewAnyVehicle,
            'offices' => $offices,
            'officeVehicles' => $vehicles->sortBy('office.id')->groupBy('office.name')
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

    public function addNewVehicle(AddNewVehicleRequest $request): RedirectResponse
    {
        $added = $this->vehicleService->new($request->validated());

        abort_if(!$added, 500);

        return back()->with('success', 'New vehicle added successfully!');
    }

    public function vehicleInfo(Vehicle $vehicle, Request $request): View
    {
        if($request->user()->cannot('viewAny', Vehicle::class) || $request->user()->cannot('view', $vehicle))
            abort(403);

        $vehicle = $this->vehicleService->loadOtherVehicleInfo($vehicle);

        $vehicleClassifications = $this->vehicleClassificationService->vehicleClassifications();
        $vehicleMakes = $this->vehicleMakeService->vehicleMakes();
        $offices = $this->officeService->offices();
        $yearNow = $this->yearService->getYear()->year;

        return view('vehicle-info', [
            'vehicle' => $vehicle,
            'vehicleClassifications' => $vehicleClassifications,
            'vehicleMakes' => $vehicleMakes,
            'offices' => $offices,
            'yearNow' => $yearNow
        ]);
    }

    public function updateVehicle(Vehicle $vehicle)
    {
        $request = app(EditVehicleInfoRequest::class, ['vehicle' => $vehicle]);

        $updated = $this->vehicleService->edit($vehicle, $request->validated());

        abort_if(!$updated, 500);

        return back()->with('success', 'Vehicle info updated successfully!');
    }
}
