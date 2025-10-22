<?php

namespace App\Services;

use App\Enums\ReportValidity;
use App\Models\WitnessReport;
use App\Repositories\WitnessReportRepository;

class StoreWitnessReportService
{
    public function store(array $data): ?WitnessReport
    {
//        dd($data['query'], $data['phone'], $data['ip']);
        $match = (new GetFbiMatchService)->get($data['query']);
        $phoneInfo = (new GetPhoneInfoService)->get($data['phone']);
        $country = (new GetCountryService)->get($data['phone'], $data['ip']);

        $validity = ($match && $phoneInfo->isValid) ?
            ReportValidity::VALID :
            ReportValidity::INVALID;

        return app(WitnessReportRepository::class)->store([
            'query' => $data['query'],
            'phone_e164' => $phoneInfo->e164,
            'phone_valid' => $phoneInfo->isValid,
            'client_country' => $country,
            'ip' => $data['ip'],
            'fbi_uid' => $match?->uid,
            'fbi_title' => $match?->title,
            'fbi_url' => $match?->url,
            'validity' => $validity->value,
        ]);
    }
}
