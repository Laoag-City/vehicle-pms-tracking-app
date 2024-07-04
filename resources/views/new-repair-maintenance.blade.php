<x-layout>
    <x-slot:title>New Repair/Maintenance Record</x-slot>

    <div class="ten wide centered column">
        <x-contents.header class="primary block">
            <x-slot:main>{{ $vehicle->completeVehicleName() }}</x-slot>
            {{ $vehicle->office->name }} | Plate No: {{ $vehicle->plate_number }}
        </x-contents.header>

        <div class="ui divider"></div>

        <form action="{{ url()->current() }}" method="POST" class="ui form {{ $errors->any() ? 'error' : 'success' }}">
            @csrf

            <h4 class="ui header">New Repair/Maintenance Record</h4>

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
                :selected="old('component')"
                :error="$errors->first('component')"
                :required="true"
            />
            
            <x-forms.text-field
                label="Description"
                name="description"
                :value="old('description')"
                :error="$errors->first('description')"
                :required="true"
            />

            <div class="fields">
                <div class="five wide field">
                    <x-forms.radio-button-field
                        label="Type"
                        name="type"
                        :values="$isRepairValues"
                        :checked="old('type')"
                        :error="$errors->first('type')"
                        :inline="false"
                        :required="true"
                    />
                </div>

                <x-forms.text-field
                    class="five wide"
                    label="Estimated Cost"
                    name="estimated_cost"
                    :value="old('estimated_cost')"
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
                    :value="old('date_encoded')"
                    type="date"
                    :error="$errors->first('date_encoded')"
                    :required="true"
                />
            </div>

            <div class="field">
                <x-actions.button class="small blue fluid" type="submit">
                    Add Repair/Maintenance
                </x-actions.button>
            </div>
        </form>
    </div>
</x-layout>