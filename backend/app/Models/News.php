<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class News extends Model
{
    use HasFactory;

    protected $fillable = [
        'title',
        'news',
        'status'
    ];

    public static function defaultSortAttribute(): string
    {
        return 'title';
    }

    public static function rules(): array
    {
        return [
            'title' => 'required|max:255',
            'news' => 'required|string',
        ];
    }

}
