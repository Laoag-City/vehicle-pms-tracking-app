<x-layout>
    <x-slot:title>Add Repair/Maintenance Record</x-slot>

    <div class="eight wide centered column">
        <h3 class="ui block header">
            {{ $vehicle->completeVehicleName() }}
            
            <div class="sub header">
                {{ $vehicle->office->name }}
            </div>
        </h3>

        <div class="ui divider"></div>

        <form action="{{ url()->current() }}" method="POST" class="ui form {{ $errors->any() ? 'error' : 'success' }}">
            @csrf

            <h4 class="ui header">Add Repair/Maintenance Record</h4>

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

            <x-forms.radio-button-field
                label="Type"
                name="type"
                :values="['Repair', 'Maintenance']"
                :checked="old('type')"
                :error="$errors->first('type')"
                :required="true"
            />

            <div class="field">
                <x-actions.button class="small blue fluid" type="submit">
                    Add Record
                </x-actions.button>
            </div>
        </form>
    </div>
</x-layout>