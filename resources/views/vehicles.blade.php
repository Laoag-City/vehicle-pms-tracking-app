<x-layout>
    <x-slot:title>Vehicles</x-slot>

    <div class="twelve wide centered column">
        @if($canViewAnyVehicle)
            <form href="{{ url()->current() }}" method="GET" class="ui small form">
                <div class="fields">
                    @if(!request('office_filter'))
                        <div class="two wide field"></div>
                    @endif

                    <x-forms.select-field
                        class="eight wide"
                        label="Office Filter"
                        name="office_filter"
                        :options="$offices"
                        :selected="request('office_filter')"
                        :error="$errors->first('office_filter')"
                        :required="true"
                    />

                    <div class="four wide field" style="align-self: flex-end;">
                        <x-actions.button class="fluid basic yellow mini" type="submit">
                            Filter by Office
                        </x-actions.button>
                    </div>

                    @if(request('office_filter'))
                        <div class="four wide field" style="align-self: flex-end;">
                            <a href="{{ url()->current() }}" class="ui fluid basic red mini button">Remove Filter</a>
                        </div>
                    @endif
                </div>
            </form>

            <div class="ui divider"></div>
            <br>
        @endif

        @foreach($officeVehicles as $office => $vehicles)
            <h2 class="ui header">{{ $office }}</h2>

            <x-contents.items
                :vehicles="$vehicles"
            />

            <div class="ui section divider"></div>
            <br>
        @endforeach
    </div>
</x-layout>