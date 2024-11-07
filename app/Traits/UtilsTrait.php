<?php
namespace App\Traits;

use Carbon\Carbon;

trait UtilsTrait
{
    function dateNow(String $format)
    {
       return Carbon::now()->format($format);
    }
}
