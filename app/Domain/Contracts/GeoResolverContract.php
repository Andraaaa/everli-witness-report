<?php

namespace App\Domain\Contracts;

use App\Domain\ValueObjects\PhoneNumberVO;

interface GeoResolverContract
{
    public function resolve(?string $ip, ?PhoneNumberVO $phoneNumber): ?string;
}
