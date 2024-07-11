<?php

namespace App\Services;

use App\Models\Role;
use Illuminate\Database\Eloquent\Collection;

class RoleService
{
    public function roles(): Collection
    {
        return Role::all();
    }
}
