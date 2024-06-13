<?php

namespace App\Traits;

trait Sanitize
{
    private function removeSpecialCharacters(string $data): string
    {
        return preg_replace('/[^A-Za-z0-9]/', '', $data);
    }    
}
