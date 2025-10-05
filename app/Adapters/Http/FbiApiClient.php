<?php

namespace App\Adapters\Http;

use App\Domain\Contracts\FbiCasesContract;
use App\Domain\DTOs\FbiCaseMatch;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Str;

class FbiApiClient implements FbiCasesContract
{

    function findCase(string $query): ?FbiCaseMatch
    {
        $key = 'fbi:q:' .md5($query);

        return cache()->remember($key, 60, function () use ($query) {
           $response = Http::timeout(10)->retry(3, 10)
               ->baseUrl(config('services.fbi.url'))
               ->get('list', ['q' => $query, 'pageSize' => 50]);
           if (!$response->ok()) return null;

            $items = collect($response->json('items') ?? []);

            $match = $items
                ->filter(function ($case) use ($query) {
                    $title = Str::lower($case['title'] ?? '');
                    return Str::contains($title, Str::lower($query));
                });

            if ($match) {
                return new FbiCaseMatch(
                    $match['uid'] ?? '',
                    $match['title'] ?? '',
                    $match['url'] ?? null
                );
            }
           return null;
        });
    }
}
