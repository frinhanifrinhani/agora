<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;

class Role extends Authenticatable
{
    use HasFactory;

    protected $table = 'roles';

    protected $fillable = [
        'nome',
        'descricao',
    ];

    public static function searchable(): array
    {
        return [
            'nome',
        ];
    }

    public static function defaultSortAttribute(): string
    {
        return 'nome';
    }

    public static function rules(): array
    {
        return [
            'nome'          => 'required|string',
            'descricao'     => 'string',
        ];
    }
}
