<?php

namespace App\Repositories;

use App\Models\File;

class FileRepository extends BaseRepository
{
    /**
     * @inheritDoc
     */
    public function getFieldsSearchable()
    {
        return File::searchable();
    }

    /**
     * @inheritDoc
     */
    public function model()
    {
        return File::class;
    }

    public function findOrFail($id)
    {
        return $this->model->findOrFail($id);
    }
}
