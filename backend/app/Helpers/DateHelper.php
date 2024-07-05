<?php

namespace App\Helpers;

use Carbon\Carbon;

trait DateHelper
{

    public function getNow()
    {
        $now = Carbon::now();
        return $now->toDateTimeString();
    }
}
