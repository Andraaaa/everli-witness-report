<?php

namespace App\Services;

use App\Domain\Contracts\GeoResolverContract;
use App\Domain\ValueObjects\PhoneNumberVO;

class GetCountryService
{
    public function get(string $phone, string $ip): ?string
    {
        $phoneInfo = PhoneNumberVO::parse($phone, 'US');

        return (! $phoneInfo->region) ?
            app(GeoResolverContract::class)->resolve($ip, $phoneInfo) :
            $phoneInfo->region;

    }
}
