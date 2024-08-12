<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class FilesEvents extends Model
{
    protected $table = 'files_events';

    protected $primaryKey = ['file_id', 'events_id'];

    public $incrementing = false;

    protected $keyType = 'int';

    protected $fillable = [
        'file_id',
        'events_id'
    ];

    public function file()
    {
        return $this->belongsTo(File::class, 'file_id');
    }

    public function news()
    {
        return $this->belongsTo(News::class, 'events_id');
    }

    protected function setKeysForSaveQuery($query)
    {
        $query->where('file_id', $this->getAttribute('file_id'))
              ->where('events_id', $this->getAttribute('events_id'));
        return $query;
    }
}