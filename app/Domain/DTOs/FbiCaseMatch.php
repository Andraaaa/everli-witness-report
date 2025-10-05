<?php

namespace App\Domain\DTOs;

use SebastianBergmann\CodeCoverage\Report\Xml\Report;

final class FbiCaseMatch
{
    public function __construct(
        public readonly string $uid,
        public readonly string $title,
        public readonly ?string $url
    ) {}
}
