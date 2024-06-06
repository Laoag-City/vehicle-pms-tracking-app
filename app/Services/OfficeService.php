<?php

namespace App\Services;

use App\Models\Office;

class OfficeService
{
    public function offices()
    {
        return Office::all();
    }
}
