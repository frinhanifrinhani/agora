<?php

namespace App\Models;

use App\Helpers\DateHelper;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class NewsComment extends Model
{
    use HasFactory, DateHelper;

    protected $fillable = [
        'news_id',
        'user_id',
        'description',
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
        return 'description';
    }

    public static function rules(): array
    {
        return [
            'id'=>'',
            'description' => 'required|max:255',
        ];
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function comment()
    {
        return $this->hasMany(News::class)->orderBy('id');
    }

}
