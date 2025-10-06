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
        $r = $event->report;

        $payload = [
            'id'             => $r->id,
            'created_at'     => $r->created_at?->toIso8601String(),
            'query'          => $r->query,
            'phone_e164'     => $r->phone_e164,
            'phone_valid'    => $r->phone_valid,
            'client_country' => $r->client_country,
            'ip'             => $r->ip,
            'fbi_uid'        => $r->fbi_uid,
            'fbi_title'      => $r->fbi_title,
            'fbi_url'        => $r->fbi_url,
            'validity'       => $r->validity->value,
        ];

        // jednostavno: jedan fajl po prijavi
        Storage::disk('local')->put(
            "reports/{$r->id}.json",
            json_encode($payload, JSON_UNESCAPED_UNICODE | JSON_PRETTY_PRINT)
        );
    }
}
