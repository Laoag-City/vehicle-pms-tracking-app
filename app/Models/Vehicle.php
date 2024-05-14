<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Vehicle extends Model
{
    use HasFactory;

    public function office(): BelongsTo
    {
        return $this->belongsTo(Office::class);
    }

    public function vehicle_classification(): BelongsTo
    {
        return $this->belongsTo(VehicleClassification::class);
    }

    public function vehicle_make(): BelongsTo
    {
        return $this->belongsTo(VehicleMake::class);
    }

    public function repair_and_maintenances(): HasMany
    {
        return $this->hasMany(RepairAndMaintenance::class);
    }
}
