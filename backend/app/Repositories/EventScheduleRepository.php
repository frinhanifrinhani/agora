<?php

namespace App\Repositories;

use App\Models\EventSchedule;

class EventScheduleRepository extends BaseRepository
{
    /**
     * @inheritDoc
     */
    public function getFieldsSearchable()
    {
        return EventSchedule::searchable();
    }

    /**
     * @inheritDoc
     */
    public function model()
    {
        return EventSchedule::class;
    }

    public function findOrFail($id)
    {
        return $this->model->findOrFail($id);
    }
}
