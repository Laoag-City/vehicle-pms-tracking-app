<x-layout>
    <x-slot:title>Vehicle Info</x-slot>

    <div class="eight wide centered column">
        <h3 class="ui block header">
            {{ $vehicle->completeVehicleName() }}
            
            <div class="sub header">
                {{ $vehicle->office->name }}
            </div>
        </h3>

        <br>
        
        <form action="{{ url()->current() }}" method="POST" class="ui form {{ $errors->any() ? 'error' : 'success' }}" x-data="form">
            @csrf
            @method('PUT')

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

            @can('update', $vehicle)
                <x-forms.checkbox-field
                    label="Edit"
                    name="edit_mode"
                    :value="1"
                    :checked="old('edit_mode')"
                    :error="$errors->first('edit_mode')"
                    style="float: right;"
                    js-bind="editModeBind"
                />
            @endcan

            {{--Vehicle Classification--}}
            <template x-if="!editMode">
                <x-forms.text-field
                    label="Vehicle Classification"
                    name="classification"
                    :value="$vehicle->vehicle_classification->classification"
                    :readonly="true"
                />
            </template>

            <template x-if="editMode">
                <x-forms.select-field
                    label="Vehicle Classification"
                    name="vehicle_classification"
                    :options="$vehicleClassifications"
                    :selected="old('vehicle_classification') ? old('vehicle_classification') : $vehicle->vehicle_classification_id"
                    :error="$errors->first('vehicle_classification')"
                    :required="true"
                />
            </template>
            {{--  --}}

            {{--Vehicle Make--}}
            <template x-if="!editMode">
                <x-forms.text-field
                    label="Vehicle Make"
                    name="make"
                    :value="$vehicle->vehicle_make->make"
                    :readonly="true"
                />
            </template>

            <div x-show="editMode">
                <input 
                    id="show_make_list" 
                    type="hidden" 
                    name="show_make_list"
                    x-model="showMakeList"
                    data-initial-value="{{ old('show_make_list') != null ? old('show_make_list') : 1 }}"
                    data-vehicle-make-initial-value="{{ old('vehicle_make') ? old('vehicle_make') : $vehicle->vehicle_make_id }}"
                >

                <template x-if="showMakeList">
                    <div class="fields">
                        <x-forms.select-field
                            class="ten wide"
                            label="Vehicle Make List"
                            name="vehicle_make"
                            :options="$vehicleMakes"
                            :error="$errors->first('vehicle_make')"
                            :required="true"
                            js-bind="vehicleMakeListBind"
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
            </div>
            {{--  --}}

            {{--Office--}}
            <template x-if="!editMode">
                <x-forms.text-field
                    label="Office"
                    name="office"
                    :value="$vehicle->office->name"
                    :readonly="true"
                />
            </template>

            <template x-if="editMode">
                <x-forms.select-field
                    label="Office Issued To"
                    name="office_issued_to"
                    :options="$offices"
                    :selected="old('office_issued_to') ? old('office_issued_to') : $vehicle->office_id"
                    :error="$errors->first('office_issued_to')"
                    :required="true"
                />
            </template>
            {{--  --}}

            {{--Model, Year, Plate--}}
            <template x-if="!editMode">
                <div class="fields">
                    <x-forms.text-field
                        class="eight wide"
                        label="Model"
                        name="vehicle_model"
                        :value="$vehicle->model"
                        :readonly="true"
                    />

                    <x-forms.text-field
                        class="three wide"
                        label="Year Model"
                        name="year"
                        :value="$vehicle->year->year"
                        :readonly="true"
                    />

                    <x-forms.text-field
                        class="five wide"
                        label="Plate Number"
                        name="plate"
                        :value="$vehicle->plate_number"
                        :readonly="true"
                    />
                </div>
            </template>

            <template x-if="editMode">
                <div class="fields">
                    <x-forms.text-field
                        class="eight wide"
                        label="Model"
                        name="model"
                        :value="old('model') ? old('model') : $vehicle->model"
                        :error="$errors->first('model')"
                        :required="true"
                    />

                    <x-forms.text-field
                        class="three wide"
                        label="Year Model"
                        name="year_model"
                        type="number"
                        :value="old('year_model') ? old('year_model') : $vehicle->year->year"
                        :error="$errors->first('year_model')"
                        :required="true"
                        min="1950"
                        :max="$yearNow"
                    />

                    <x-forms.text-field
                        class="five wide"
                        label="Plate Number"
                        name="plate_number"
                        :value="old('plate_number') ? old('plate_number'): $vehicle->plate_number"
                        :error="$errors->first('plate_number')"
                        :required="true"
                    />
                </div>
            </template>

            <template x-if="editMode">
                <div class="field">
                    <x-actions.button class="small blue fluid" type="submit">
                        Edit Vehicle
                    </x-actions.button>
                </div>
            </template>
        </form>
    </div>

    <div class="fourteen wide centered column">
        <br>

        <div class="ui large horizontal section divider">Repair and Maintenances</div>
    </div>

    @pushOnce('scripts')
        <script>
            document.addEventListener('alpine:init', () => {
                Alpine.data('form', () => ({
                    editMode: false,
                    showMakeList: false,
                    vehicleMakeInitialVal: '',
                    vehicleMake: '',

                    editModeBind: {
                        ['@click']() {
                            this.editMode = !this.editMode;
                            this.vehicleMake = this.vehicleMakeInitialVal;
                            this.showMakeList = 1;
                        }
                    },

                    vehicleMakeListBind: {
                        ['x-model']: 'vehicleMake'
                    },

                    switchVehicleMakeField(toggle)
                    {
                        this.showMakeList = toggle;
                    },

                    init()
                    {
                        this.editMode = document.getElementById('edit_mode') != null ? document.getElementById('edit_mode').checked : false;
                        this.showMakeList = parseInt(document.getElementById('show_make_list').dataset.initialValue);
                        this.vehicleMakeInitialVal = document.getElementById('show_make_list').dataset.vehicleMakeInitialValue;
                        this.vehicleMake = this.vehicleMakeInitialVal;
                    }
                }));
            });
        </script>
    @endPushOnce
</x-layout>