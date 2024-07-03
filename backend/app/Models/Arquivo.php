<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Arquivo extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'path',
        'full_path',
        'file',
        'type',
        'size',
        'extension'
    ];

    public static function defaultSortAttribute(): string
    {
        return 'title';
    }

    public static function rules(): array
    {
        return [
            'name' => 'required|max:255',
            'file' => 'required',
        ];
    }

}
