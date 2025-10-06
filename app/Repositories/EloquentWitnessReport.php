<?php

namespace App\Repositories;

use App\Models\WitnessReport;
use Illuminate\Database\Eloquent\Builder;

class EloquentWitnessReport implements WitnessReportRepository
{
    function store(array $data): ?WitnessReport
    {
        $query = $this->newQuery();

        $witnessReport = $query->create($data);

        return $witnessReport->fresh();
    }

    protected function newQuery(): Builder
    {
        return (new WitnessReport())->newQuery();
    }
}
