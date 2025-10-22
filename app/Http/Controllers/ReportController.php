<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreWitnessReportRequest;
use App\Services\StoreWitnessReportService;
use Illuminate\Http\JsonResponse;

class ReportController extends Controller
{
    public function store(StoreWitnessReportRequest $request): ?JsonResponse
    {
        return response()->json((new StoreWitnessReportService)->store(
            $request->all() + [
                'ip' => $request->clientIpResolved(),
            ]), 201);
    }
}
