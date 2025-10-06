<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreWitnessReportRequest;
use App\Services\StoreWitnessReportService;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class ReportController extends Controller
{
    public function store(StoreWitnessReportRequest $request): ?JsonResponse
    {
        $query = $request->queryString();
        $phone = $request->phoneString();
        $ip    = $request->clientIpResolved();

        return response()->json((new StoreWitnessReportService())->store([
            'query' => $query,
            'phone' => $phone,
            'ip' => $ip
        ]), 201);
    }
}
