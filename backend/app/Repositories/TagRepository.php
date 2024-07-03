<?php

namespace App\Repositories;

use App\Models\Tag;

class TagRepository extends BaseRepository
{
    /**
     * @inheritDoc
     */
    public function getFieldsSearchable()
    {
        return Tag::searchable();
    }

    /**
     * @inheritDoc
     */
    public function model()
    {
        return Tag::class;
    }

    public function findOrFail($id)
    {
        return $this->model->findOrFail($id);
    }
}
