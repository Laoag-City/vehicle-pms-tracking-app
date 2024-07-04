<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Support\Str;

class Vehicle extends Model
{
    use HasFactory;

    public function office(): BelongsTo
    {
        return $this->belongsTo(Office::class);
    }

    public function vehicleClassification(): BelongsTo
    {
        return $this->belongsTo(VehicleClassification::class);
    }

    public function vehicleMake(): BelongsTo
    {
        return $this->belongsTo(VehicleMake::class);
    }

    public function year(): BelongsTo
    {
        return $this->belongsTo(Year::class);
    }

    public function repairAndMaintenances(): HasMany
    {
        return $this->hasMany(RepairAndMaintenance::class);
    }

    protected function plateNumber(): Attribute
    {
        return Attribute::make(
            set: fn (string $value) => Str::upper($value)
        );
    }

    public function completeVehicleName(): string
    {
        return "{$this->year->year} {$this->vehicleMake->make} {$this->model}";
    }
}
