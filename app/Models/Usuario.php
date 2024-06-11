<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class Usuario extends Authenticatable
{
    use HasFactory;

    protected $table = 'usuarios';

    protected $fillable = [
        'nome',
        'cpf',
        'email',
        'telefone',
        'status',
        'role_id',
    ];

    public static function searchable(): array
    {
        return [
            'nome',
        ];
    }

    public static function deafultSortAttribute(): string
    {
        return 'nome';
    }

    public static function rules(): array
    {
        return [
            'nome'          => 'required|string',
            'cpf'           => 'required|string',
            'email'         => 'required|email',
            'telefone'      => 'nullable|string',
            'status'        => 'nullable|bool',
        ];
    }

    public function role()
    {
        return $this->belongsTo(Role::class, 'role_id', 'id');
    }

}
