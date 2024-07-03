<?php

namespace App\Policies;

use App\Models\RepairAndMaintenance;
use App\Models\User;
use App\Enum\Role;
use Illuminate\Auth\Access\Response;

class RepairAndMaintenancePolicy
{
    /**
     * Determine whether the user can create models.
     */
    public function create(User $user): bool
    {
        return $user->role->role == Role::GSO_Encoder->value;
    }

    /**
     * Determine whether the user can update the model.
     */
    public function update(User $user, RepairAndMaintenance $repairAndMaintenance): bool
    {
        return $user->role->role == Role::GSO_Administrator->value;
    }

    /**
     * Determine whether the user can delete the model.
     */
    public function delete(User $user, RepairAndMaintenance $repairAndMaintenance): bool
    {
        return $user->role->role == Role::GSO_Administrator->value;
    }
}
