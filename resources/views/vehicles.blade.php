<x-layout>
    <x-slot:title>Vehicles</x-slot>

    <div class="twelve wide centered column">
        @if($canViewAnyVehicle)
            <x-forms.office-filter-form
                :offices="$offices"
            />

            <div class="ui divider"></div>
            <br>
        @endif

        @foreach($officeVehicles as $office => $vehicles)
            <h2 class="ui header">
                {{ $office }}

                @php
                    $count = $vehicles->count();
                @endphp

                <div class="sub header">{{ $count . ($count > 1 ? ' records' : ' record') }}</div>
            </h2>

            <x-contents.vehicle-items
                :vehicles="$vehicles"
                :modal-id="$modalId"
            />

            <div class="ui section divider"></div>
            <br>
        @endforeach
    </div>

    <x-forms.delete-modal
        :modal-id="$modalId"
        modal-header="Remove Vehicle"
        modal-title="Are you sure you want to remove the selected vehicle?"
        :url="route('delete_vehicle', ['vehicle' => 0])"
        :url-param="0"
    />
</x-layout>