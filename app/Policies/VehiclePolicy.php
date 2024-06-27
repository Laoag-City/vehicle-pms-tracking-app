<?php

namespace App\Policies;

use App\Enum\Role;
use App\Models\User;
use App\Models\Vehicle;
use Illuminate\Auth\Access\Response;

class VehiclePolicy
{
    /**
     * Determine whether the user can view any models.
     */
    public function viewAny(User $user): bool
    {
        $notAllowed = Role::toCollection()->whereIn('role', ['Regular User', 'Administrator']);

        return $notAllowed->doesntContain('role', $user->role->role);
    }

    /**
     * Determine whether the user can view the model.
     */
    public function view(User $user, Vehicle $vehicle): bool
    {
        return $user->office->id == $vehicle->office->id || $this->viewAny($user);
    }

    /**
     * Determine whether the user can create models.
     */
    public function create(User $user): bool
    {
        return $user->role->role == Role::GSO_Administrator->value;
    }

    /**
     * Determine whether the user can update the model.
     */
    public function update(User $user, Vehicle $vehicle): bool
    {
        return $user->role->role == Role::GSO_Administrator->value;
    }

    /**
     * Determine whether the user can delete the model.
     */
    public function delete(User $user, Vehicle $vehicle): bool
    {
        return $user->role->role == Role::GSO_Administrator->value;
    }
}
