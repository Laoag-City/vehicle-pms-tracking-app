@props([
    'vehicles' => []
])

<div class="ui items">
    @foreach($vehicles as $vehicle)
        <div class="item">
            <div class="content">
                <div class="header">
                    {{ $vehicle->completeVehicleName() }}
                </div>

                <div class="meta">
                    <span>Classification: <b>{{ $vehicle->vehicleClassification->classification }}</b></span>
                    <span>Plate Number: <b>{{ $vehicle->plate_number }}</b></span>
                </div>

                <div class="description">
                    @foreach(App\Models\RepairAndMaintenance::$isRepairValues as $key => $val)
                        <a class="ui basic primary tag label" style="margin-right: 10px;">
                            {{ "$key: {$vehicle->repairAndMaintenances->where('is_repair', $key)->count()}" }}
                        </a>
                    @endforeach
                </div>

                <div class="extra">
                    @can('delete', $vehicle)
                        <a href="" class="ui right floated red basic mini button">
                            <i class="close icon"></i>
                            Remove
                        </a>
                    @endcan

                    @can('create', App\Models\RepairAndMaintenance::class)
                        <a href="{{ route('new_repair_and_maintenance', ['vehicle' => $vehicle->id]) }}" class="ui right floated teal basic mini button">
                            <i class="plus icon"></i>
                            Add Repair/Maintenance
                        </a>
                    @endcan

                    <a href="{{ route('vehicle_info', ['vehicle' => $vehicle]) }}" class="ui right floated blue basic mini button">
                        <i class="ul list icon"></i>
                        Info
                    </a>
                </div>
            </div>
        </div>
    @endforeach
</div>