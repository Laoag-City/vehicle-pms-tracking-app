@use('Illuminate\Support\Str')

<x-layout>
    <x-slot:title>Vehicle Info</x-slot>

    <div class="eight wide centered column">
        <a class="ui basic mini button" href="{{ route('vehicles') }}">
            <i class="caret left icon"></i>
            Back
        </a>

        @can('create', App\Models\RepairAndMaintenance::class)
            <a class="ui basic teal right floated mini button" href="{{ route('new_repair_and_maintenance', ['vehicle' => $vehicle->id]) }}">
                <i class="plus icon"></i>
                Add Repair/Maintenance
            </a>
        @endcan

        @can('delete', $vehicle)
            <a class="ui right floated red basic mini button" data-id="{{ $vehicle->id }}" data-name="{{ $vehicle->completeVehicleName() }}" x-data @click="$dispatch('{{ Str::of($vehicleModalId)->kebab() }}-clicked', $el.dataset)">
                <i class="close icon"></i>
                Remove
            </a>
        @endcan
        
        <x-contents.header class="primary block">
            <x-slot:main>{{ $vehicle->completeVehicleName() }}</x-slot>
            {{ $vehicle->office->name }}
        </x-contents.header>

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
                    :value="$vehicle->vehicleClassification->classification"
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
                    :value="$vehicle->vehicleMake->make"
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
                        :value="$yearModel"
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
                        :value="old('year_model') ? old('year_model') : $yearModel"
                        :error="$errors->first('year_model')"
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
            {{-- --}}

            {{--Office--}}
            <template x-if="!editMode">
                <x-forms.text-field
                    label="Serial Number"
                    name="serial_number"
                    :value="$vehicle->serial_number"
                    :readonly="true"
                />
            </template>

            <template x-if="editMode">
                <x-forms.text-field
                    label="Serial Number"
                    name="serial_number"
                    :value="old('serial_number') ? old('serial_number') : $vehicle->serial_number"
                    :error="$errors->first('serial_number')"
                    :required="true"
                />
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

    <div class="sixteen wide centered column">
        <br>

        <div class="ui large horizontal section divider">Repairs and Maintenances</div>

        <div class="ui two statistics" style="margin: 20px 0 20px 0;">
            <div class="ui mini statistic">
                <div class="value">
                    <i class="money bill alternate outline icon"></i>
                    {{ number_format($vehicle->repairAndMaintenances->sum('estimated_cost'), 2) }}
                </div>
                <div class="label">Total Estimated Cost</div>
            </div>

            <div class="ui mini statistic">
                <div class="value">
                    <i class="ul list icon"></i>
                    {{ $vehicle->repairAndMaintenances->count() }}
                </div>
                <div class="label">Records</div>
            </div>
        </div>

        <x-contents.table class="small celled center aligned stackable selectable striped">
            <x-slot:head>
                <tr>
                    <th>Description</th>
                    <th>Component</th>
                    <th class="collapsing">Type</th>
                    <th class="collapsing">Estimated Cost</th>
                    <th class="collapsing">Date Encoded</th>
                    @if($canUpdateRepairAndMaintenance || $canDeleteRepairAndMaintenance)
                        <th class="collapsing"></th>
                    @endif
                </tr>
            </x-slot>

            <x-slot:body>
                @foreach($repairAndMaintenances as $item)
                    <tr>
                        <td>{{ $item->description }}</td>
                        <td>{{ $item->component->component }}</td>
                        <td>{{ $item->is_repair }}</td>
                        <td>{{ $item->prettyEstimatedCost() }}</td>
                        <td>{{ $item->date_encoded }}</td>
                        @if($canUpdateRepairAndMaintenance || $canDeleteRepairAndMaintenance)
                            <td>
                                <x-actions.simple-dropdown class="small">
                                    <x-slot:label>
                                        <i class="small bars icon"></i>
                                    </x-slot>
                                    
                                    @if($canUpdateRepairAndMaintenance)
                                        <a class="item" href="{{ route('repair_and_maintenance_info', ['vehicle' => $vehicle->id, 'repairAndMaintenance' => $item->id]) }}">Edit</a>
                                    @endif

                                    @if($canDeleteRepairAndMaintenance)
                                        <a class="item" data-id="{{ $item->id }}" data-name="{{ $item->description }}" x-data @click="$dispatch('{{ Str::of($repairModalId)->kebab() }}-clicked', $el.dataset)">
                                            Remove
                                        </a>
                                    @endif
                                </x-actions.simple-dropdown>
                            </td>
                        @endif
                    </tr>
                @endforeach
            </x-slot>
        </x-contents.table>

        {{ $repairAndMaintenances->links('vendor.pagination.semantic-ui') }}

        <br>

        @can('delete', $vehicle)
            <x-forms.delete-modal
                :modal-id="$vehicleModalId"
                modal-header="Remove Vehicle"
                modal-title="Are you sure you want to remove the selected vehicle?"
                :url="route('delete_vehicle', ['vehicle' => 0])"
                :url-param="0"
            />
        @endcan

        @if($canDeleteRepairAndMaintenance)
        <x-forms.delete-modal
            :modal-id="$repairModalId"
            modal-header="Remove Repair/Maintenance"
            modal-title="Are you sure you want to remove the selected record?"
            :url="route('delete_repair_and_maintenance', ['vehicle' => $vehicle->id, 'repairAndMaintenance' => 0])"
            :url-param="0"
        />
        @endif
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