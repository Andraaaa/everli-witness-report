<?php

namespace App\Adapters\Geo;

use App\Domain\Contracts\GeoResolverContract;
use App\Domain\ValueObjects\PhoneNumberVO;

final readonly class GeoResolver implements GeoResolverContract
{
    public function __construct(
        private IpLookStrategy $ip,
    ) {}

    function resolve(?string $ip, ?PhoneNumberVO $phoneNumber): ?string
    {
        if ($phoneNumber?->region) return strtoupper($phoneNumber->region);
        return $this->ip->country($ip);
    }
}
