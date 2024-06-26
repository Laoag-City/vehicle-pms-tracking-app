<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use App\Interfaces\SelectFieldDataInterface;

class Office extends Model implements SelectFieldDataInterface
{
    use HasFactory;

    public function users(): HasMany
    {
        return $this->hasMany(User::class);
    }

    public function vehicles(): HasMany
    {
        return $this->HasMany(Vehicle::class);
    }

    public function selectName()
    {
        return $this->name;
    }

    public function selectValue()
    {
        return $this->id;
    }
}
