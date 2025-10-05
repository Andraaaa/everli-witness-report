<?php

namespace App\Http\Controllers;

use App\Services\GetCountryService;
use App\Services\GetFbiMatch;
use App\Services\GetPhoneInfo;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class ReportController extends Controller
{
    public function store(Request $request): JsonResponse
    {
        $query = (string)$request->input('query');
        $phone = (string)$request->input('phone', '');
        $ip = $request->header('X-Forwarded-For') ?
            explode(',', $request->header('X-Forwarded-For'))[0] :
            $request->ip();

        return response()->json([
            'client_country' => (new GetCountryService())->get($phone, $ip),
            'fbi_match' => (new GetFbiMatch())->get($query),
            'phone' => (new GetPhoneInfo())->get($phone),
        ], 201);
    }
}
