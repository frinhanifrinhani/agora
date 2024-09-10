<?php

namespace App\Models;

use App\Helpers\DateHelper;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Event extends Model
{
    use HasFactory, DateHelper;

    protected $fillable = [
        'title',
        'body',
        'alias',
        'start_date',
        'start_time',
        'end_date',
        'end_time',
        'organizer',
        'ddd',
        'phone',
        'email',
        'address',
        'location',
        'location_alias',
        'venue',
        'venue_alias',
        'sidebar_button_link',
        'publicated',
        'user_id',
        'publication_date',
    ];

    public function getStartDateAttribute($value)
    {
        return $this->returnBrazilianDefaultDate($value);
    }

    public function getEndDateAttribute($value)
    {
        return $this->returnBrazilianDefaultDate($value);
    }

    public function getCreatedAtAttribute($value)
    {
        return $this->returnBrazilianDefaultDateHour($value);
    }

    public function getUpdatedAtAttribute($value)
    {
        return $this->returnBrazilianDefaultDateHour($value);
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
            'start_date'=> 'required',
            'start_time'=> 'required',
            'end_date'=> 'required',
            'end_time'=> 'required',
            'organizer'=> 'required',
            'ddd'=> '',
            'phone'=> '',
            'email'=> '',
            'address'=> 'required',
            'location'=>'',
            'venue'=>'',
            'schedule'=>'',
            'tags' => ''
        ];
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function filesEvents()
    {
        return $this->hasMany(FilesEvents::class, 'events_id', 'id');
    }

    public function file()
    {
        return $this->belongsToMany(File::class, 'files_events', 'events_id', 'file_id');
    }

    public function tag()
    {
        return $this->belongsToMany(Tag::class, 'event_tags', 'event_id','tag_id' );
    }

    public function eventSchedule()
    {
        return $this->hasMany(EventSchedule::class)->orderBy('order');
    }

    public function syncEventSchedule(array $eventSchedule)
    {
        $eventScheduleIds = collect($eventSchedule)->pluck('id')->filter()->all();

        $this->eventSchedule()->whereNotIn('id', $eventScheduleIds)->delete();

        foreach ($eventSchedule as $schedule) {
            if (isset($schedule['id'])) {
                $this->eventSchedule()->where('id', $schedule['id'])->update($schedule);
            } else {
                $this->eventSchedule()->create($schedule);
            }
        }
    }
}
