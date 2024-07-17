<x-layout>
    <x-slot:title>Repairs and Maintenances</x-slot>

    <x-slot:css>
        <style>
            @media print {
                div.pusher {
                    padding: 1;
                    margin: 0;
                }

                div#content {
                    border: none;
                    padding: 0;
                    margin: 0;
                }

                div.pusher>div.container>div.menu,
                div#content>div.container>div.fourteen.column,
                #printButton {
                    display: none;
                }

                h3#tableHeader {
                    margin: 0;
                }
            }
        </style>
    </x-slot>

    <div class="fourteen wide centered column">
        @if($canViewAnyVehicle)
            <x-forms.office-filter-form
                :offices="$offices"
            />

            <div class="ui divider"></div>
            <br>
        @endif
    </div>

    @if($vehicles->pluck('repairAndMaintenances')->flatten()->isNotEmpty())
        <div class="sixteen wide centered column">
            <x-actions.button type="button" id="printButton" class="teal basic right floated" onclick="window.print()">
                <i class="print icon"></i>
                Print
            </x-actions.button>

            <h3 id="tableHeader" class="ui header">{{ $vehicles[0]->office->name }}</h3>

            <x-contents.table class="small grey celled center aligned stackable structured striped">
                <x-slot:head>
                        <tr>
                            <th>Vehicle</th>
                            <th>Description</th>
                            <th>Component</th>
                            <th class="collapsing">Type</th>
                            <th class="collapsing">Estimated Cost</th>
                            <th class="collapsing">Date Encoded</th>
                        </tr>
                    </x-slot>

                    <x-slot:body>
                        @foreach($vehicles as $vehicle)
                            @foreach($vehicle->repairAndMaintenances as $item)
                                <tr>
                                    @if($loop->first)
                                        <td rowspan="{{ $vehicle->repairAndMaintenances->count() }}">{{ $vehicle->completeVehicleName() }}</td>
                                    @endif

                                    <td>{{ $item->description }}</td>
                                    <td>{{ $item->component->component }}</td>
                                    <td>{{ $item->is_repair }}</td>
                                    <td>{{ $item->prettyEstimatedCost() }}</td>
                                    <td>{{ $item->date_encoded }}</td>
                                </tr>
                            @endforeach
                        @endforeach
                    </x-slot>
            </x-contents.table>
        </div>
    @endif
</x-layout>