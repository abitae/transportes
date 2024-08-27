<?php

namespace App\Traits;

use Illuminate\Support\Facades\Log;

trait LogCustom
{
    function infoLog($campo)
    {
        Log::build([
            'driver' => 'single',
            'path' => storage_path('logs/success.log'),
        ])->info($campo);
        return true;
    }
    function errorLog($campo, $e)
    {
        Log::build([
            'driver' => 'single',
            'path' => storage_path('logs/error.log'),
        ])->error($campo . ' Error: ' . $e->getMessage());
        return true;
    }
}
