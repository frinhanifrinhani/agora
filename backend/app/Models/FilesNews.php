<?php

namespace App\Models;

use App\Helpers\DateHelper;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class FilesNews extends Model
{
    protected $table = 'files_news';

    protected $primaryKey = ['file_id', 'news_id'];

    public $incrementing = false;

    protected $keyType = 'int';

    protected $fillable = [
        'file_id',
        'news_id'
    ];

    public function file()
    {
        return $this->belongsTo(File::class, 'file_id');
    }

    public function news()
    {
        return $this->belongsTo(News::class, 'news_id');
    }

    protected function setKeysForSaveQuery($query)
    {
        $query->where('file_id', $this->getAttribute('file_id'))
              ->where('news_id', $this->getAttribute('news_id'));
        return $query;
    }
}
