<?php

namespace App\Services;

use App\Jobs\CreateKpiJob;

class KPIServiceV2
{
    public function store($fileContent)
    {
        foreach ($fileContent as $kpi) {
            // creating the separate jobs to prevent timeout, so they can run one after another
            CreateKpiJob::dispatch($kpi);
        }

        // $success = array();
        // $failed = array();

        // foreach ($fileContent as $kpi) {
        //     $stored = $kpiServiceV1->store($kpi);

        //     $stored ? $success[] = $stored : $failed[] = $kpi;
        // }

        // return [
        //     'success' => $success,
        //     'failed' => $failed,
        // ];
    }
}
