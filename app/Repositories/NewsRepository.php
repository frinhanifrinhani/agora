<?php

namespace App\Repositories;

use App\Models\News;

class NewsRepository extends BaseRepository
{
    /**
     * @inheritDoc
     */
    public function getFieldsSearchable()
    {
        return News::searchable();
    }

    /**
     * @inheritDoc
     */
    public function model()
    {
        return News::class;
    }

    public function findOrFail($id)
    {
        return $this->model->findOrFail($id);
    }
}
