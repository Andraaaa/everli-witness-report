<?php

namespace App\Services;

use App\Domain\ValueObjects\PhoneNumberVO;
use App\Enums\ReportValidity;

class GetPhoneInfo
{
    public function get(string $phoneNumber): array
    {
        $phoneInfo = PhoneNumberVO::parse($phoneNumber, 'US');

        return [
            'valid'=> ($phoneInfo->isValid) ? ReportValidity::VALID : ReportValidity::INVALID,
            'e164'=> $phoneInfo->e164,
            'region'=> $phoneInfo->region
        ];
    }
}
