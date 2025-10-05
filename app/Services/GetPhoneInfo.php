<?php

namespace App\Services;

use App\Domain\ValueObjects\PhoneNumberVO;

class GetPhoneInfo
{
    public function get(string $phoneNumber): array
    {
        $phoneInfo = PhoneNumberVO::parse($phoneNumber, 'US');

        return [
            'valid'=> $phoneInfo->isValid,
            'e164'=> $phoneInfo->e164,
            'region'=> $phoneInfo->region
        ];
    }
}
