@props([
    'vehicles' => []
])

<div class="ui items">
    @foreach($vehicles as $vehicle)
        <div class="item">
            <div class="content">
                <div class="header">
                    {{ "{$vehicle->year->year} {$vehicle->vehicle_make->make} {$vehicle->model}" }}
                </div>

                <div class="meta">
                    <span>Classification: <b>{{ $vehicle->vehicle_classification->classification }}</b></span>
                    <span>Plate Number: <b>{{ $vehicle->plate_number }}</b></span>
                </div>

                <div class="description">
                    Total of {{ $vehicle->repair_and_maintenances->where('is_repair', true)->count() }} repairs and 
                    {{ $vehicle->repair_and_maintenances->where('is_repair', false)->count() }} maintenances.
                </div>

                <div class="extra">
                    @can('delete', $vehicle)
                        <a href="" class="ui right floated red basic mini button">Remove</a>
                    @endcan

                    @can('update', $vehicle)
                        <a href="" class="ui right floated yellow basic mini button">Edit</a>
                    @endcan

                    <a href="" class="ui right floated blue basic mini button">Repair/Maintenance Info</a>
                </div>
            </div>
        </div>
    @endforeach
</div>