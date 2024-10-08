<?php

namespace App\Http\Controllers;

use App\Http\Requests\AddNewVehicleRequest;
use App\Http\Requests\EditVehicleInfoRequest;
use App\Http\Requests\OfficeFilterRequest;
use App\Models\RepairAndMaintenance;
use App\Models\Vehicle;
use App\Services\OfficeService;
use App\Services\RepairAndMaintenanceService;
use App\Services\VehicleClassificationService;
use App\Services\VehicleMakeService;
use App\Services\VehicleService;
use App\Services\YearService;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class VehicleController extends Controller
{
    public function __construct(private VehicleService $vehicleService, 
                                private VehicleClassificationService $vehicleClassificationService, 
                                private VehicleMakeService $vehicleMakeService, 
                                private OfficeService $officeService,
                                private YearService $yearService,
                                private RepairAndMaintenanceService $repairAndMaintenanceService)
    {

    }

    public function getVehicles(Request $request): View
    {
        $offices = [];
        $canViewAnyVehicle = $request->user()->can('viewAny', Vehicle::class);

        if($canViewAnyVehicle)
        {
            $offices = $this->officeService->offices()->sortBy('name');

            if(!$request->office_filter)
                $vehicles = $this->vehicleService->vehicles();

            else
            {
                app(OfficeFilterRequest::class);

                $office = $offices->where('id', $request->office_filter)->first();

                $vehicles = $this->vehicleService->vehicles($office->id);
            }
        }

        else
            $vehicles = $this->vehicleService->vehicles($request->user()->office_id);

        return view('vehicles', [
            'canViewAnyVehicle' => $canViewAnyVehicle,
            'offices' => $offices,
            'officeVehicles' => $vehicles->sortBy('office.id')->groupBy('office.name'),
            'modalId' => 'deleteModal'
        ]);
    }

    public function newVehicle(): View
    {
        $vehicleClassifications = $this->vehicleClassificationService->vehicleClassifications()->sortBy('classification');
        $vehicleMakes = $this->vehicleMakeService->vehicleMakes()->sortBy('make');
        $offices = $this->officeService->offices()->sortBy('name');
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
        if($request->user()->can('viewAny', Vehicle::class) || $request->user()->can('view', $vehicle))
        {
            $vehicle = $this->vehicleService->loadOtherVehicleInfo($vehicle);

            if($request->user()->can('update', $vehicle))
            {
                $vehicleClassifications = $this->vehicleClassificationService->vehicleClassifications()->sortBy('classification');
                $vehicleMakes = $this->vehicleMakeService->vehicleMakes()->sortBy('make');
                $offices = $this->officeService->offices()->sortBy('name');
                $yearNow = $this->yearService->getYear()->year;
            }

            else
            {
                $vehicleClassifications = $vehicleMakes = $offices = [];
                $yearNow = null;
            }

            $repairAndMaintenance = new RepairAndMaintenance;
            $canUpdateRepairAndMaintenance = $request->user()->can('update', $repairAndMaintenance);
            $canDeleteRepairAndMaintenance = $request->user()->can('delete', $repairAndMaintenance);

            return view('vehicle-info', [
                'vehicle' => $vehicle,
                'vehicleClassifications' => $vehicleClassifications,
                'vehicleMakes' => $vehicleMakes,
                'offices' => $offices,
                'yearNow' => $yearNow,
                'repairAndMaintenances' => $this->repairAndMaintenanceService->getPaginatedRecords($vehicle, 150),
                'canUpdateRepairAndMaintenance' => $canUpdateRepairAndMaintenance,
                'canDeleteRepairAndMaintenance' => $canDeleteRepairAndMaintenance,
                'vehicleModalId' => 'vehicleModal',
                'repairModalId' => 'repairModal',
                'yearModel' => $vehicle->year ? $vehicle->year->year : ''
            ]);
        }

        abort(403);
    }

    public function updateVehicle(Vehicle $vehicle): RedirectResponse
    {
        $request = app(EditVehicleInfoRequest::class, ['vehicle' => $vehicle]);

        $updated = $this->vehicleService->edit($vehicle, $request->validated());

        abort_if(!$updated, 500);

        return back()->with('success', 'Vehicle info updated successfully!');
    }

    public function deleteVehicle(Vehicle $vehicle): RedirectResponse
    {
        $deleted = $this->vehicleService->delete($vehicle);

        abort_if(!$deleted, 500);

        return redirect(route('vehicles'));
    }
}
