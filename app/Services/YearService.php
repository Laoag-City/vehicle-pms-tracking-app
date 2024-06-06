<?php

namespace App\Services;

use App\Models\Vehicle;
use App\Models\Year;

class YearService
{
    public function getYear($year = null)
    {
        if(!$year)
            $year = date('Y', strtotime('now'));

        return Year::firstOrCreate(['year' => $year]);
    }

    public function vehiclesInYear($year)
    {
        $year = Year::where('year', $year)->first();

        return Vehicle::where('year_id', $year->id)->get();
    }
}
