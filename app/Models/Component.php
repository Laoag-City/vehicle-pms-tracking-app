<?php

namespace App\Models;

use App\Interfaces\SelectFieldDataInterface;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Component extends Model implements SelectFieldDataInterface
{
    use HasFactory;

    public function repair_and_maintenances(): HasMany
    {
        return $this->hasMany(RepairAndMaintenance::class);
    }

    public function selectName()
    {
        return $this->component;
    }

    public function selectValue()
    {
        return $this->id;
    }
}
