<x-layout>
    <x-slot:title>Log In</x-slot>

    <div class="four wide column">
        <form action="{{ url()->current() }}" method="POST" class="ui form">
            @csrf
    
            <x-forms.text-field
                label="Username"
                name="username"
                :value="old('username')"
                :error="$errors->first('username')"
                :required="true"
            />

            <x-forms.text-field
                label="Password"
                name="password"
                type="password"
                value=""
                :required="true"
            />

            <x-actions.button class="blue fluid" type="submit">
                Log In
            </x-actions.button>
        </form>
    </div>
</x-layout>