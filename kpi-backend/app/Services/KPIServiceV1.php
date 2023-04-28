<?php

namespace App\Services;

use App\Models\KPI;

class KPIServiceV1
{

    public function store($kpi)
    {
        try {
            $kpi = KPI::create($kpi);
            return $kpi;
        } catch (\Throwable $th) {
            return false;
        }
    }
}
