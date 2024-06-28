<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;

use App\Rules\ValidateCpf;
use Laravel\Sanctum\HasApiTokens;
use Illuminate\Notifications\Notifiable;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;

class User extends Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'name',
        'cpf',
        'email',
        'phone',
        'password',
        'status',
        'role_id',
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array<int, string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    protected $visible = [
        'name',
        'cpf',
        'email',
        'phone',
        'status',
        'role_id',
        'email_verified_at',
        'password',
        'remember_token',
        'updated_at',
        'created_at',
        'id',
    ];

    /**
     * Get the attributes that should be cast.
     *
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'password' => 'hashed',
        ];
    }


    public static function defaultSortAttribute(): string
    {
        return 'name';
    }

    public static function rules(): array
    {
        return [
            'name' => 'required|string',
            'cpf' => ['required', new ValidateCpf],
            'email' => 'required|email|max:100',
            'phone' => 'nullable|string',
            'password' => 'required|string|min:6|max:12',
        ];
    }
}
