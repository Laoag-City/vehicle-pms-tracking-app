<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class VehicleMake extends Model
{
    use HasFactory;

    public function vehicles(): HasMany
    {
        return $this->hasMany(Vehicle::class);
    }

    public function selectName()
    {
        return $this->make;
    }

    public function selectValue()
    {
        return $this->id;
    }
}
