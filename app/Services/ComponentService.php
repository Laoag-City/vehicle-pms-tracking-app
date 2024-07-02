<?php

namespace App\Services;

use App\Models\Component;

class ComponentService
{
    public function components()
    {
        return Component::all();
    }
}
