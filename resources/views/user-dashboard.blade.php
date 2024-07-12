<x-layout>
    <x-slot:title>Users Dashboard</x-slot>

    <div class="sixteen wide column">
        <h3 class="ui header">User List</h3>

        <x-contents.table class="striped center aligned selectable stackable celled scrolling">
            <x-slot:head>
                <tr>
                    <th>Name</th>
                    <th>Username</th>
                    <th>Office</th>
                    <th>Role</th>
                    <th></th>
                </tr>
            </x-slot>

            <x-slot:body>
                @foreach($users as $user)
                    <tr>
                        <td>{{ $user->name }}</td>
                        <td>{{ $user->username }}</td>
                        <td>{{ $user->office->abbr }}</td>
                        <td>{{ $user->role->role }}</td>
                        <td>
                            <x-actions.simple-dropdown class="small">
                                <x-slot:label>
                                    <i class="small bars icon"></i>
                                </x-slot>
                                
                                <a class="item" href="{{ route('edit_user', ['user' => $user->id]) }}">
                                    Edit
                                </a>

                                <a class="item" data-id="{{ $user->id }}" data-name="{{ $user->name }}" x-data @click="$dispatch('{{ Str::of($modalId)->kebab() }}-clicked', $el.dataset)">
                                    Remove
                                </a>
                            </x-actions.simple-dropdown>
                        </td>
                    </tr>
                @endforeach
            </x-slot>
        </x-contents.table>

        <br>

        <div class="ui section divider"></div>
    </div>

    <div class="six wide centered column">
        <h3 class="ui header">New User</h3>

        <form action="{{ url()->current() }}" method="POST" class="ui form {{ $errors->any() ? 'error' : 'success' }}">
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

            <x-forms.text-field
                label="Name"
                name="name"
                :value="old('name')"
                :error="$errors->first('name')"
                :required="true"
            />

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
                :value="old('password')"
                :error="$errors->first('password')"
                :required="true"
            />

            <x-forms.text-field
                label="Password Confirmation"
                name="password_confirmation"
                type="password"
                :value="old('password_confirmation')"
                :error="$errors->first('password_confirmation')"
                :required="true"
            />

            <x-forms.select-field
                label="Office"
                name="office"
                :options="$offices"
                :selected="old('office')"
                :error="$errors->first('office')"
                :required="true"
            />

            <x-forms.select-field
                label="Role"
                name="role"
                :options="$roles"
                :selected="old('role')"
                :error="$errors->first('role')"
                :required="true"
            />

            <div class="field">
                <x-actions.button class="small blue fluid" type="submit">
                    Add User
                </x-actions.button>
            </div>
        </form>
    </div>

    <x-forms.delete-modal
        :modal-id="$modalId"
        modal-header="Remove User"
        modal-title="Are you sure you want to remove the selected user?"
        :url="route('delete_user', ['user' => 0])"
        :url-param="0"
    />
</x-layout>