<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreKPILegacyRequest;
use App\Http\Requests\StoreKPIRequest;
use App\Http\Resources\KpiResource;
use App\Rules\KpiDuplicateEmailRule;
use App\Services\KPIServiceV1;
use App\Services\KPIServiceV2;
use Validator;

class KPIController extends Controller
{

    public function storeLegacy(StoreKPILegacyRequest $request, KPIServiceV1 $kpiServiceV1)
    {
        $kpi = $request->validated();
        $storedKpi = $kpiServiceV1->store($kpi);

        return response()->json([
            'message' => 'Kpi record stored!',
            'success' => $storedKpi ? new KpiResource($storedKpi) : [],
            'failed' => !$storedKpi ? new KpiResource($storedKpi) : [],
        ], 201);
    }


    public function store(StoreKPIRequest $request, KPIServiceV2 $kpiServiceV2)
    {
        //validate schema
        $kpi = $request->validated();
        $fileContent = json_decode($kpi['file']->getContent(), true);

        $validator = Validator::make($fileContent,  [
            '*.email' => 'required|email|unique:kpis,email',
            '*.year' => 'required|numeric|digits:4',
            '*.month' => 'required|numeric|between:1,12',
            '*.value' => 'required|numeric',
            '*.type' => 'required|string',
            '*.subtype' => 'required|string',
        ]);

        if ($validator->fails()) {
            return response()->json(
                $validator->errors()->all(),
                400
            );
        }

        // for async
        $kpiServiceV2->store($fileContent);

        return response()->json([
            'message' => 'Kpi File Uploaded!',
        ], 201);

        // $result = $kpiServiceV2->store($kpi['file_content'], $kpiServiceV1);

        // return response()->json([
        //     'message' => 'Kpi File Uploaded!',
        //     'success' => KpiResource::collection($result['success']),
        //     'failed' => KpiResource::collection($result['failed']),
        // ], 201);
    }

    public function status()
    {
        $numberOfRemainingJobs = \DB::table('jobs')->where('payload', 'like', '%CreateKpiJob"%')->count();
        $numberOfFailedJobs = \DB::table('failed_jobs')->where('payload', 'like', '%CreateKpiJob"%')->count();

        return response()->json([
            'count' => $numberOfRemainingJobs,
            'message' => $numberOfRemainingJobs ? "In Progress, $numberOfRemainingJobs records in the queue" : 'Completed, No record in the queue',
            'failed' => $numberOfFailedJobs . ' record Failed',
        ], 200);
    }
}
