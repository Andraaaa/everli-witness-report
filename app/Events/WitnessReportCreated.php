<?php

namespace App\Events;

use App\Models\WitnessReport;
use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;

class WitnessReportCreated
{
    use Dispatchable, InteractsWithSockets, SerializesModels;

    public function __construct(public readonly WitnessReport $report) {}

}
