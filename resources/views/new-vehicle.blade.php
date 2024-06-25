<x-layout>
    <x-slot:title>Add Vehicle</x-slot>

    <div class="eight wide centered column">
        <form action="{{ url()->current() }}" method="POST" class="ui form {{ $errors->any() ? 'error' : 'success' }}" x-data="form">
            @csrf

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
                label="Vehicle Classification"
                name="vehicle_classification"
                :options="$vehicleClassifications"
                :selected="old('vehicle_classification')"
                :error="$errors->first('vehicle_classification')"
                :required="true"
            />

            <input 
                id="show_make_list" 
                type="hidden" 
                name="show_make_list"
                x-model="showMakeList"
                data-initial-value="{{ old('show_make_list') != null ? old('show_make_list') : 1 }}">

            <template x-if="showMakeList">
                <div class="fields">
                    <x-forms.select-field
                        class="ten wide"
                        label="Vehicle Make List"
                        name="vehicle_make"
                        :options="$vehicleMakes"
                        :selected="old('vehicle_make')"
                        :error="$errors->first('vehicle_make')"
                        :required="true"
                    />

                    <div class="six wide field" style="	align-self: flex-end;">
                        <x-actions.button class="small blue inverted" x-on:click="switchVehicleMakeField(0)">
                            Switch to New Vehicle Make
                        </x-actions.button>
                    </div>
                </div>
            </template>

            <template x-if="!showMakeList">
                <div class="fields">
                    <x-forms.text-field
                        class="ten wide"
                        label="New Vehicle Make"
                        name="new_vehicle_make"
                        :value="old('new_vehicle_make')"
                        :error="$errors->first('new_vehicle_make')"
                        :required="true"
                    />

                    <div class="six wide field" style="	align-self: flex-end;">
                        <x-actions.button class="small blue inverted" x-on:click="switchVehicleMakeField(1)">
                            Switch to Vehicle Make List
                        </x-actions.button>
                    </div>
                </div>
            </template>

            <x-forms.select-field
                label="Office Issued To"
                name="office_issued_to"
                :options="$offices"
                :selected="old('office_issued_to')"
                :error="$errors->first('office_issued_to')"
                :required="true"
            />

            <div class="fields">
                <x-forms.text-field
                    class="eight wide"
                    label="Model"
                    name="model"
                    :value="old('model')"
                    :error="$errors->first('model')"
                    :required="true"
                />

                <x-forms.text-field
                    class="three wide"
                    label="Year"
                    name="year"
                    type="number"
                    :value="old('year')"
                    :error="$errors->first('year')"
                    :required="true"
                    min="1950"
                    :max="$yearNow"
                />

                <x-forms.text-field
                    class="five wide"
                    label="Plate Number"
                    name="plate_number"
                    :value="old('plate_number')"
                    :error="$errors->first('plate_number')"
                    :required="true"
                />
            </div>

            <div class="field">
                <x-actions.button class="small blue fluid" type="submit">
                    Add Vehicle
                </x-actions.button>
            </div>
        </form>
    </div>

    @pushOnce('scripts')
        <script>
            document.addEventListener('alpine:init', () => {
                Alpine.data('form', () => ({
                    showMakeList: '',

                    switchVehicleMakeField(toggle)
                    {
                        this.showMakeList = toggle;
                    },

                    init()
                    {
                        this.showMakeList = parseInt(document.getElementById('show_make_list').dataset.initialValue);
                    }
                }));
            });
        </script>
    @endPushOnce
</x-layout>