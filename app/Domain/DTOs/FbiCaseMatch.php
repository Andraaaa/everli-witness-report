<?php

namespace App\Domain\DTOs;

final class FbiCaseMatch
{
    public function __construct(
        public readonly string $uid,
        public readonly string $title,
        public readonly ?string $url
    ) {}
}
