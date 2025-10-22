<?php

namespace App\Enums;

enum ReportValidity: string
{
    case VALID = 'VALID';
    case INVALID = 'INVALID';
    case UNKNOWN = 'UNKNOWN';
}
