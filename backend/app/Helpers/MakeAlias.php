<?php

namespace App\Helpers;

use Illuminate\Support\Str;

class MakeAlias
{
    public function stringToAlias($string)
    {
        $treatedString = mb_strtolower($string, 'UTF-8');

        $treatedString = Str::ascii($treatedString);

        $treatedString = str_replace([' ', '_'], '-', $treatedString);

        $treatedString = preg_replace('/[^a-z0-9-]/', '', $treatedString);

        $treatedString = preg_replace('/-+/', '-', $treatedString);

        return $treatedString;
    }
}
