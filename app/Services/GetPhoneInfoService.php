<?php

namespace App\Services;

use App\Domain\ValueObjects\PhoneNumberVO;
use App\Enums\ReportValidity;

class GetPhoneInfoService
{
    public function get(string $phoneNumber): ?PhoneNumberVO
    {
        return PhoneNumberVO::parse($phoneNumber, 'US');
    }
}
