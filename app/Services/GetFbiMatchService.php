<?php

namespace App\Services;

use App\Domain\Contracts\FbiCasesContract;
use App\Domain\DTOs\FbiCaseMatch;

class GetFbiMatchService
{
     public function get(string $query): ?FbiCaseMatch
     {
         return $query ? app(FbiCasesContract::class)->findCase($query) : null;
     }
}
