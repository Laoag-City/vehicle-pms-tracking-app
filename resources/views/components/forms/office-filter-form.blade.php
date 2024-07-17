@props([
    'href' => url()->current(),
    'offices'
])

<form href="{{ $href }}" method="GET" class="ui small form">
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
                <a href="{{ $href }}" class="ui fluid basic red mini button">Remove Filter</a>
            </div>
        @endif
    </div>
</form>