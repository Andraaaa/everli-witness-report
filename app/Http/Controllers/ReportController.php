<?php

namespace App\Http\Controllers;

use App\Domain\Contracts\FbiCasesContract;
use App\Domain\ValueObjects\PhoneNumberVO;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class ReportController extends Controller
{
    public function store(Request $request): JsonResponse
    {
        $query = (string)$request->input('query');
        $phone = (string)$request->input('phone', '');

        $match = $query ? app(FbiCasesContract::class)->findCase($query) : null;

        $phone = PhoneNumberVO::parse($phone, 'US');

        return response()->json([
            'fbi_match' => $match ? ['uid'=>$match->uid,'title'=>$match->title,'url'=>$match->url] : null,
            'phone' => ['valid'=>$phone->isValid, 'e164'=>$phone->e164, 'region'=>$phone->region],
        ], 201);
    }
}
