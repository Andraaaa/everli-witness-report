<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class WitnessReport extends Model
{
    protected $fillable = [
        'query','phone_e164','phone_valid','client_country','ip',
        'fbi_uid','fbi_title','fbi_url','validity'
    ];
}
