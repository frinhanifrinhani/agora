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
        'open_to_comments',
        'user_id',
        'publication_date',
        'created_at',
        'updated_at',
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
            'open_to_comments' => '',
            'categories' => '',
            'tags' => '',
            'created_at' => '',
            'updated_at' => '',
        ];
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function category()
    {
        return $this->belongsToMany(Category::class, 'news_categories', 'news_id','category_id' )->withTimestamps();
    }


    public function tag()
    {
        return $this->belongsToMany(Tag::class, 'news_tags', 'news_id','tag_id' )->withTimestamps();
    }

    public function filesNews()
    {
        return $this->hasMany(FilesNews::class, 'news_id', 'id');
    }

    public function file()
    {
        return $this->belongsToMany(File::class, 'files_news', 'news_id', 'file_id');
    }

    public function comment()
    {
        return $this->hasMany(Comment::class);
    }
}
