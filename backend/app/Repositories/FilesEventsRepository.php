<?php

namespace App\Repositories;

use App\Models\FilesEvents;

class FilesEventsRepository extends BaseRepository
{
    /**
     * @inheritDoc
     */
    public function getFieldsSearchable()
    {
        return FilesEvents::searchable();
    }

    /**
     * @inheritDoc
     */
    public function model()
    {
        return FilesEvents::class;
    }

    public function findOrFail($id)
    {
        return $this->model->findOrFail($id);
    }

    public function storeFilesEvents($eventsId, $fileId)
    {
        return FilesEvents::create([
            'events_id' => $eventsId,
            'file_id' => $fileId
        ]);
    }
}