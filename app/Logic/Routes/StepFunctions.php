<?php

namespace App\Services;

use App\Models\Authentication;
use App\Models\Connection;

use App\Services\LogService;

class StepFunctions
{
    public static function createTextVariable($text)
    {
        return $text;
    }
}
