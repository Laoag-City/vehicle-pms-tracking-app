<?php

namespace App\Services;

use App\Models\Office;

class OfficeService
{
    public function offices()
    {
        return Office::all();
    }

    public function getOffice($id)
    {
        return Office::find($id);
    }
}
