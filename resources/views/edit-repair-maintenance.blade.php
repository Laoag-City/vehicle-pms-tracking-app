<x-layout>
    <x-slot:title>Edit Repair/Maintenance</x-slot>

    <div class="ten wide centered column">
        <a class="ui basic mini button" href="{{ route('vehicle_info', ['vehicle' => $vehicle->id]) }}">
            <i class="caret left icon"></i>
            Back
        </a>

        <x-contents.header class="primary block">
            <x-slot:main>{{ $vehicle->completeVehicleName() }}</x-slot>
            {{ $vehicle->office->name }} | Plate No: {{ $vehicle->plate_number }}
        </x-contents.header>

        <div class="ui divider"></div>

        <form action="{{ url()->current() }}" method="POST" class="ui form {{ $errors->any() ? 'error' : 'success' }}">
            @csrf
            @method('PUT')

            <h4 class="ui header">Edit Repair/Maintenance Record</h4>

            <br>

            @if($errors->any())
                <x-contents.message class="error">
                    <x-slot:header>Oops! Something went wrong.</x-slot>
                </x-contents.message>
            @endif

            @if(session('success'))
                <x-contents.message class="success">
                    <x-slot:header>{{ session('success') }}</x-slot>
                </x-contents.message>
            @endif

            <x-forms.select-field
                label="Component"
                name="component"
                :options="$components"
                :selected="old('component') ? old('component') : $repairAndMaintenance->component_id"
                :error="$errors->first('component')"
                :required="true"
            />
            
            <x-forms.text-field
                label="Description"
                name="description"
                :value="old('description') ? old('description') : $repairAndMaintenance->description"
                :error="$errors->first('description')"
                :required="true"
            />

            <div class="fields">
                <div class="five wide field">
                    <x-forms.radio-button-field
                        label="Type"
                        name="type"
                        :values="$isRepairValues"
                        :checked="old('type') ? old('type') : $repairAndMaintenance->is_repair"
                        :error="$errors->first('type')"
                        :inline="false"
                        :required="true"
                    />
                </div>

                <x-forms.text-field
                    class="five wide"
                    label="Estimated Cost"
                    name="estimated_cost"
                    :value="old('estimated_cost') ? old('estimated_cost') : $repairAndMaintenance->estimated_cost"
                    type="number"
                    min="1"
                    max="99999999"
                    step=".01"
                    :error="$errors->first('estimated_cost')"
                    :required="true"
                />

                <x-forms.text-field
                    class="six wide"
                    label="Date Encoded"
                    name="date_encoded"
                    :value="old('date_encoded') ? old('date_encoded') : $repairAndMaintenance->getAttributes()['date_encoded']"
                    type="date"
                    :error="$errors->first('date_encoded')"
                    :required="true"
                />
            </div>

            <div class="field">
                <x-actions.button class="small blue fluid" type="submit">
                    Edit Repair/Maintenance
                </x-actions.button>
            </div>
        </form>
    </div>
</x-layout>