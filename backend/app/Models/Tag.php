<?php

namespace App\Models;

use App\Helpers\DateHelper;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Tag extends Model
{
    use HasFactory, DateHelper;

    protected $fillable = [
        'name',
        'alias',
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
            'name' => 'required|max:255',
            'created_at' => '',
            'updated_at' => '',

        ];
    }

    public function news()
    {
        return $this->belongsToMany(News::class, 'news_tags', 'news_id', 'tag_id')->withTimestamps();
    }

    public function event()
    {
        return $this->belongsToMany(Event::class, 'event_tags', 'event_id', 'tag_id');
    }

}

