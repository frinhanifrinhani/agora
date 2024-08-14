<?php

namespace App\Models;

use App\Helpers\DateHelper;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Category extends Model
{
    use HasFactory, DateHelper;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'name',
        'description',
        'alias',
        'status'
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
        return 'name';
    }

    public static function rules(): array
    {
        return [
            'name' => 'required',
            'description' => '',
            'status' => '',
            'created_at' => '',
            'updated_at' => '',
        ];
    }

    public function news()
    {
        return $this->belongsToMany(News::class, 'news_categories', 'news_id', 'category_id')->withTimestamps();
    }
}
