<?php

namespace App\Domain\Contracts;

use App\Domain\ValueObjects\PhoneNumberVO;

interface GeoResolverContract
{
    function resolve(?string $ip, ?PhoneNumberVO $phoneNumber): ?string;
}
