<?php

namespace App\Models;

use App\Enums\ReportValidity;
use Illuminate\Database\Eloquent\Model;

class WitnessReport extends Model
{
    protected $table = 'witness_reports';
    protected $fillable = [
        'query','phone_e164','phone_valid','client_country','ip',
        'fbi_uid','fbi_title','fbi_url','validity'
    ];

    protected $casts = [
        'phone_valid' => 'bool',
        'validity' => ReportValidity::class,
    ];
}
