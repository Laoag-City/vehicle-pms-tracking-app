<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Component extends Model
{
    use HasFactory;

    public function repair_and_maintenances(): HasMany
    {
        return $this->hasMany(RepairAndMaintenance::class);
    }
}
