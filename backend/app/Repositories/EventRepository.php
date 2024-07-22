<?php

namespace App\Repositories;

use App\Models\Event;

class EventRepository extends BaseRepository
{
    /**
     * @inheritDoc
     */
    public function getFieldsSearchable()
    {
        return Event::searchable();
    }

    /**
     * @inheritDoc
     */
    public function model()
    {
        return Event::class;
    }

    public function findOrFail($id)
    {
        return $this->model->findOrFail($id);
    }
}
