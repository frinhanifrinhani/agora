<?php

namespace App\Models;

use App\Helpers\DateHelper;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class File extends Model
{
    use HasFactory, DateHelper;

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

    public function getCreatedAtAttribute($value)
    {
        return $this->returnBrazilianDefaultDate($value);
    }

    public function getUpdatedAtAttribute($value)
    {
        return $this->returnBrazilianDefaultDate($value);
    }

    public function news()
    {
        return $this->belongsToMany(News::class, 'files_news', 'file_id', 'news_id');
    }
}
