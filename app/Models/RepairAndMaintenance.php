<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class RepairAndMaintenance extends Model
{
    use HasFactory;

    public function vehicle(): BelongsTo
    {
        return $this->belongsTo(Vehicle::class);
    }

    public function component(): BelongsTo
    {
        return $this->belongsTo(Component::class);
    }

    protected function estimatedCost(): Attribute
    {
        return Attribute::make(
            get: fn(string $value) => number_format($value, 2)
        );
    }

    protected function isRepair(): Attribute
    {
        return Attribute::make(
            get: fn(string $value) => $value ? 'Repair' : 'Maintenance'
        );
    }

    protected function dateEncoded(): Attribute
    {
        return Attribute::make(
            get: fn(string $value) => date('M d, Y', strtotime($value))
        );
    }
}
