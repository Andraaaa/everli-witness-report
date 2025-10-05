<?php

namespace App\Adapters\Geo;

use Illuminate\Support\Facades\Http;

class IpLookStrategy
{
    public function country(?string $ip): ?string
    {
        if (!$ip) return null;

        try {
            $response = Http::timeout(5)->retry(2, 100)->get("https://ipapi.co/{$ip}/json/");
            return strtoupper((string) ($response->json('country') ?? ''))?: null;
        } catch (\Throwable) {
            return null;
        }
    }
}
