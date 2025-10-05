<?php

namespace App\Domain\ValueObjects;

use libphonenumber\NumberParseException;
use libphonenumber\PhoneNumberFormat;
use libphonenumber\PhoneNumberUtil;

class PhoneNumberVO
{
    public function __construct(
        public readonly ?string $e164,
        public readonly bool $isValid,
        public readonly ?string $region
    ) {}

    public static function parse(string $input, ?string $defaultRegion = 'US'): self
    {
        $util = PhoneNumberUtil::getInstance();

        try {
            $number = $util->parse($input, $defaultRegion);
            $valid = $util->isValidNumber($number);
            $e164 = $valid ? $util->format($number, PhoneNumberFormat::E164) : null;
            $region = $util->getRegionCodeForNumber($number)?: null;
            return new self($e164, $valid, $region);
        } catch (\Throwable) {
            return new self(null, false, null);
        }
    }
}
