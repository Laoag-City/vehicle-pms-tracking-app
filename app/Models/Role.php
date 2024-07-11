<?php

namespace App\Models;

use App\Interfaces\SelectFieldDataInterface;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Role extends Model implements SelectFieldDataInterface
{
    use HasFactory;

    public function users(): HasMany
    {
        return $this->hasMany(User::class);
    }

    public function selectName()
    {
        return $this->role;
    }

    public function selectValue()
    {
        return $this->id;
    }
}
