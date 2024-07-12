<?php

namespace App\Services;

use App\Models\User;
use Illuminate\Support\Collection;

class UserService
{
    public function users(): Collection
    {
        return User::all();
    }

    public function new($validatedData): bool
    {
        $user = new User;

        $user->office_id = $validatedData['office'];
        $user->role_id = $validatedData['role'];
        $user->name = $validatedData['name'];
        $user->username = $validatedData['username'];
        $user->password = bcrypt($validatedData['password']);

        return $user->save();
    }

    public function edit(User $user, $validatedData): bool
    {
        $user->office_id = $validatedData['office'];
        $user->role_id = $validatedData['role'];
        $user->name = $validatedData['name'];
        $user->username = $validatedData['username'];

        if($validatedData['update_password'])
            $user->password = bcrypt($validatedData['update_password']);

        return $user->save();
    }

    public function delete(User $user): bool
    {
        return $user->delete();
    }
}
