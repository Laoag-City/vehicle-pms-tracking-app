<x-layout>
    <x-slot:title>New Repair/Maintenance Record</x-slot>

    <div class="fourteen wide centered column">
        <a class="ui basic mini button" href="{{ route('vehicle_info', ['vehicle' => $vehicle->id]) }}">
            <i class="caret left icon"></i>
            Back
        </a>
        
        <x-contents.header class="primary block">
            <x-slot:main>{{ $vehicle->completeVehicleName() }}</x-slot>
            {{ $vehicle->office->name }} | Plate No: {{ $vehicle->plate_number }}
        </x-contents.header>

        <div class="ui divider"></div>

        <form action="{{ url()->current() }}" method="POST" class="ui form {{ $errors->any() ? 'error' : 'success' }}" x-data="form">
            @csrf

            <h3 class="ui header">New Repair/Maintenance Record</h3>

            <br>

            @if($errors->any())
                <x-contents.message class="error">
                    <x-slot:header>Oops! Something went wrong.</x-slot>

                    <ul class="ui bulleted list">
                        @foreach($errors->all() as $error)
                            <li class="item">{{ $error }}</li>
                        @endforeach
                    </ul>
                </x-contents.message>
            @endif

            @if(session('success'))
                <x-contents.message class="success">
                    <x-slot:header>{{ session('success') }}</x-slot>
                </x-contents.message>
            @endif

            <x-forms.text-field
                class="five wide"
                label="Date Encoded"
                name="date_encoded"
                :value="old('date_encoded')"
                type="date"
                :error="$errors->first('date_encoded')"
                :required="true"
            />

            <h4 class="ui right floated header" x-text="(additionalRows + 1) + ' / ' + (rowLimit + 1)"></h4>

            <x-contents.table id="repairMaintenanceTable" class="celled center aligned stackable selectable striped">
                <x-slot:head>
                    <tr>
                        <th>Component</th>
                        <th>Description</th>
                        <th>Type</th>
                        <th>Estimated Cost</th>
                    </tr>
                </x-slot>
                
                <x-slot:body>
                    <tr>
                        <td>
                            <x-forms.select-field
                                name="record[0][component]"
                                :options="$components"
                                :selected="old('record.0.component')"
                                :error="$errors->first('record.0.component')"
                                :required="true"
                            />
                        </td>

                        <td>
                            <x-forms.text-field
                                name="record[0][description]"
                                :value="old('record.0.description')"
                                :error="$errors->first('record.0.description')"
                                :required="true"
                            />
                        </td>

                        <td>
                            <x-forms.radio-button-field
                                name="record[0][type]"
                                :values="$isRepairValues"
                                :checked="old('record.0.type')"
                                :error="$errors->first('record.0.type')"
                                :inline="false"
                                :required="true"
                            />
                        </td>

                        <td>
                            <x-forms.text-field
                                name="record[0][estimated_cost]"
                                :value="old('record.0.estimated_cost')"
                                type="number"
                                min="1"
                                max="99999999"
                                step=".01"
                                :error="$errors->first('record.0.estimated_cost')"
                                :required="true"
                            />
                        </td>
                    </tr>

                    <template x-for="i in additionalRows">
                        <tr>
                            <td>
                                <x-forms.select-field
                                    x-bind:id="`component-${i}`"
                                    :options="$components"
                                    :required="true"
                                />
                            </td>
                
                            <td>
                                <x-forms.text-field
                                    x-bind:id="`description-${i}`"
                                    :required="true"
                                />
                            </td>
                
                            <td>
                                <x-forms.radio-button-field
                                    x-bind:id="`type-${i}`"
                                    :values="$isRepairValues"
                                    :inline="false"
                                    :required="true"
                                />
                            </td>
                
                            <td>
                                <x-forms.text-field
                                    x-bind:id="`estimated-cost-${i}`"
                                    type="number"
                                    min="1"
                                    max="99999999"
                                    step=".01"
                                    :required="true"
                                />
                            </td>
                        </tr>
                    </template>
                </x-slot>
            </x-contents.table>

            <div class="sixteen wide field" style="overflow: auto; margin-bottom: 40px;">
                <x-actions.button class="mini teal right floated" x-show="additionalRows < rowLimit" @click="toggleRow(true)">
                    <i class="plus icon"></i>
                    Add New Row
                </x-actions.button>

                <x-actions.button class="mini red right floated" x-show="additionalRows > 0" @click="toggleRow(false)">
                    <i class="minus icon"></i>
                    Remove Last Row
                </x-actions.button>
            </div>

            <div class="field">
                <x-actions.button class="small blue fluid" type="submit">
                    Add Repair/Maintenance
                </x-actions.button>
            </div>
        </form>
    </div>

    @pushOnce('scripts')
        <script>
            document.addEventListener('alpine:init', () => {
                Alpine.data('form', () => ({
                    additionalRows: {{ old('record') ? count(old('record')) - 1 : 0 }},
                    oldFormData: {{ Js::from(session()->getOldInput()) }},
                    rowLimit: 19,

                    toggleRow(add){
                        if(add){
                            this.additionalRows++;

                            this.$nextTick(() => {
                                this.setTableFieldsAttr(this.additionalRows);
                            });
                        }

                        else
                            this.additionalRows--;
                    },

                    setTableFieldsAttr(index, values = null){
                        //set the form field names in the added row

                        //component
                        let component = document.getElementById(`component-${index}`)
                                                .getElementsByTagName('select')[0];

                        component.setAttribute('name', `record[${index}][component]`);

                        component.value = values != null ? values['component'] : '' ;

                        //description
                        let description = document.getElementById(`description-${index}`)
                                                .getElementsByTagName('input')[0];

                        description.setAttribute('name', `record[${index}][description]`);
                        
                        description.value = values != null ? values['description'] : '' ;

                        //type
                        Array.from(document.getElementById(`type-${index}`)
                                .getElementsByClassName('ui radio checkbox'))
                                .forEach((element) => {
                                    //radio button
                                    let input = element.getElementsByTagName('input')[0];

                                    let name = `record[${index}][type]`;
                                    let value = input.value;

                                    input.setAttribute('id', `${name}-${value}`)
                                    input.setAttribute('name', name);

                                    input.checked = values != null && values['type'] == input.value ? true : false;

                                    //label
                                    element.getElementsByTagName('label')[0]
                                            .setAttribute('for', `${name}-${value}`);
                                });
                        
                        //estimated cost
                        let estimatedCost = document.getElementById(`estimated-cost-${index}`)
                                                    .getElementsByTagName('input')[0];

                        estimatedCost.setAttribute('name', `record[${index}][estimated_cost]`);

                        estimatedCost.value = values != null ? values['estimated_cost'] : '';
                    },

                    init(){
                        let table = document.getElementById('repairMaintenanceTable');

                        //this.additionalRows = Number(table.dataset.additionalRows);
                        //this.oldFormData = JSON.parse(table.dataset.oldData);

                        this.$nextTick(() => {
                            for(let i = 1; i <= this.additionalRows; i++)
                                this.setTableFieldsAttr(i, this.oldFormData.record[i]);
                        })
                    }
                }));
            });

            document.addEventListener('alpine:initialized', () => {
                
            })
        </script>
    @endPushOnce
</x-layout>