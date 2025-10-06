<?php

namespace App\Repositories;

use App\Models\WitnessReport;

interface WitnessReportRepository
{
    function store(array $data): ?WitnessReport;
}
