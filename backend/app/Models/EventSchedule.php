<?php

namespace App\Models;

use App\Helpers\DateHelper;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class EventSchedule extends Model
{
    use HasFactory, DateHelper;

    protected $fillable = [
        'title',
        'date',
        'time',
        'description',
        'order',
        'event_id',
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
            'date' => 'required',
            'time' => 'required',
            'description' => 'required',
            'order' => '',
            'created_at' => '',
            'updated_at' => '',
        ];
    }

    public function event()
    {
        return $this->belongsTo(Event::class);
    }

}
