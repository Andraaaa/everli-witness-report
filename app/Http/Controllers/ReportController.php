<?php

namespace App\Http\Controllers;

use App\Services\GetCountryService;
use App\Services\GetFbiMatchService;
use App\Services\GetPhoneInfoService;
use App\Services\StoreWitnessReportService;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class ReportController extends Controller
{
    public function store(Request $request): ?JsonResponse
    {
        $query = (string)$request->input('query');
        $phone = (string)$request->input('phone', '');
        $ip = $request->header('X-Forwarded-For') ?
            explode(',', $request->header('X-Forwarded-For'))[0] :
            $request->ip();

        return response()->json((new StoreWitnessReportService())->store([
            'query' => $query,
            'phone' => $phone,
            'ip' => $ip
        ]), 201);
    }
}
