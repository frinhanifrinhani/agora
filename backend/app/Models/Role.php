<?php

namespace App\Models;

use App\Helpers\DateHelper;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;

class Role extends Authenticatable
{
    use HasFactory, DateHelper;

    protected $table = 'roles';

    protected $fillable = [
        'nome',
        'descricao',
    ];

    public function getCreatedAtAttribute($value)
    {
        return $this->returnBrazilianDefaultDateHour($value);
    }

    public function getUpdatedAtAttribute($value)
    {
        return $this->returnBrazilianDefaultDateHour($value);
    }

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
