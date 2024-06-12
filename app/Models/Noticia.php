<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Noticia extends Model
{
    use HasFactory;
    protected $table = 'noticia';

    protected $fillable = [
        'titulo',
        'noticia',
        'status'
    ];

    public static function defaultSortAttribute(): string
    {
        return 'titulo';
    }

    public static function rules(): array
    {
        return [
            'titulo' => 'required|max:255',
            'noticia' => 'required|string',
        ];
    }

}
