<?php

namespace App\Jobs;

use App\Services\KPIServiceV1;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldBeUnique;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;

class CreateKpiJob implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    public $kpi;

    /**
     * Create a new job instance.
     *
     * @return void
     */
    public function __construct($kpi)
    {
        $this->kpi = $kpi;
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle(KPIServiceV1 $kpiServiceV1)
    {
        $kpiServiceV1->store($this->kpi);
    }
}
