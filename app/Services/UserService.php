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
}
