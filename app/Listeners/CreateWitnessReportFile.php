<?php

namespace App\Listeners;

use App\Events\WitnessReportCreated;
use Illuminate\Support\Facades\Storage;

class CreateWitnessReportFile
{
    /**
     * Create the event listener.
     */
    public function __construct()
    {
        //
    }


    public function handle(WitnessReportCreated $event): void
    {
        $report = $event->report;

        $payload = [
            'id'             => $report->id,
            'created_at'     => $report->created_at?->toIso8601String(),
            'query'          => $report->query,
            'phone_e164'     => $report->phone_e164,
            'phone_valid'    => $report->phone_valid,
            'client_country' => $report->client_country,
            'ip'             => $report->ip,
            'fbi_uid'        => $report->fbi_uid,
            'fbi_title'      => $report->fbi_title,
            'fbi_url'        => $report->fbi_url,
            'validity'       => $report->validity->value,
        ];

        Storage::disk('local')->put(
            "reports/{$report->id}.json",
            json_encode($payload, JSON_UNESCAPED_UNICODE | JSON_PRETTY_PRINT)
        );
    }
}
