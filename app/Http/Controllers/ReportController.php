<?php

namespace App\Http\Controllers;

use App\Domain\Contracts\FbiCasesContract;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class ReportController extends Controller
{
    public function store(Request $request): JsonResponse
    {
        $query = (string)$request->get('query');
        $match = $query ? app(FbiCasesContract::class)->findCase($query) : null;

        return response()->json([
            'fbi_match' => $match ? ['uid'=>$match->uid,'title'=>$match->title,'url'=>$match->url] : null,
        ], 201);
    }
}
