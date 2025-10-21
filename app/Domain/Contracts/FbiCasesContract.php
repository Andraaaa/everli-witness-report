<?php

namespace App\Domain\Contracts;

use App\Domain\DTOs\FbiCaseMatch;

interface FbiCasesContract
{
    public function findCase(string $query): ?FbiCaseMatch;
}
