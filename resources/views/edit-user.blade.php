<x-layout>
    <x-slot:title>Edit User</x-slot>

    <div class="six wide centered column">
        <h3 class="ui header">New User</h3>

        <form action="{{ url()->current() }}" method="POST" class="ui form {{ $errors->any() ? 'error' : 'success' }}">
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

            <x-forms.text-field
                label="Name"
                name="name"
                :value="old('name') ? old('name') : $user->name"
                :error="$errors->first('name')"
                :required="true"
            />

            <x-forms.text-field
                label="Username"
                name="username"
                :value="old('username') ? old('username') : $user->username"
                :error="$errors->first('username')"
                :required="true"
            />

            <x-forms.text-field
                label="Update Password"
                name="update_password"
                type="password"
                :value="old('update_password')"
                :error="$errors->first('update_password')"
                :required="false"
            />

            <x-forms.text-field
                label="Password Confirmation"
                name="update_password_confirmation"
                type="password"
                :value="old('update_password_confirmation')"
                :error="$errors->first('update_password_confirmation')"
                :required="false"
            />

            <x-forms.select-field
                label="Office"
                name="office"
                :options="$offices"
                :selected="old('office') ? old('office') : $user->office_id"
                :error="$errors->first('office')"
                :required="true"
            />

            <x-forms.select-field
                label="Role"
                name="role"
                :options="$roles"
                :selected="old('role') ? old('role') : $user->role_id"
                :error="$errors->first('role')"
                :required="true"
            />

            <div class="field">
                <x-actions.button class="small blue fluid" type="submit">
                    Edit User
                </x-actions.button>
            </div>
        </form>
    </div>
</x-layout>