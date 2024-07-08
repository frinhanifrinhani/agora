<?php

namespace App\Models;

use App\Helpers\DateHelper;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class News extends Model
{
    use HasFactory, DateHelper;

    protected $fillable = [
        'title',
        'body',
        'alias',
        'status',
        'publicated',
        'user_id',
        'category_id',
        'publication_date'
    ];

    public function getCreatedAtAttribute($value)
    {
        return $this->returnBrazilianDefaultDate($value);
    }

    public function getUpdatedAtAttribute($value)
    {
        return $this->returnBrazilianDefaultDate($value);
    }

    public static function defaultSortAttribute(): string
    {
        return 'title';
    }

    public static function rules(): array
    {
        return [
            'title' => 'required|max:255',
            'body' => 'required|string',
            'publicated' => '',
            'category_id' => '',
        ];
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function category()
    {
        return $this->belongsTo(Category::class);
    }
}
