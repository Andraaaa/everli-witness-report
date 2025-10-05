<?php

namespace App\Domain\Contracts;

use App\Domain\DTOs\FbiCaseMatch;

interface FbiCasesContract
{
    function findCase(string $query): ?FbiCaseMatch;
}
