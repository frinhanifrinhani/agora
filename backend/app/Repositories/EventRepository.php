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

    public function paginate($limit, $page, $type = '', $search = [])
    {
        $query = $this->allQuery();

        if ($type) {
            $query->where('type', $type);
        }

        $query->with(['eventSchedule']);
        $query->with(['tag']);

        return $query->orderBy('id', 'desc')->paginate($limit, ['*'], 'page', $page);
    }
}
