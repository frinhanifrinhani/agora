<?php

namespace App\Helpers;

use Carbon\Carbon;

trait DateHelper
{

    public function getNow()
    {
        $now = Carbon::now();
        //return $now->toDateTimeString();
        return $now->format('Y-m-d H:i:s');
    }

    public function returnBrazilianDefaultDate($value){
        return Carbon::parse($value)->format('d/m/Y H:i:s');
    }

}
