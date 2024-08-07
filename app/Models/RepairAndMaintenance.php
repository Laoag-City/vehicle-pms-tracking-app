<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class RepairAndMaintenance extends Model
{
    use HasFactory;

    public static $isRepairValues = [
        'Repair' => true,
        'Replacement' => false
    ];

    public function vehicle(): BelongsTo
    {
        return $this->belongsTo(Vehicle::class);
    }

    public function component(): BelongsTo
    {
        return $this->belongsTo(Component::class);
    }

    public function prettyEstimatedCost(): string
    {
        return number_format($this->estimated_cost, 2);
    }

    protected function isRepair(): Attribute
    {
        return Attribute::make(
            get: fn(string $value) => array_search($value, $this::$isRepairValues)
        );
    }

    protected function dateEncoded(): Attribute
    {
        return Attribute::make(
            get: fn(string $value) => date('M d, Y', strtotime($value))
        );
    }
}
