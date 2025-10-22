<?php

namespace App\Repositories;

use App\Models\WitnessReport;

interface WitnessReportRepository
{
    public function store(array $data): ?WitnessReport;
}
