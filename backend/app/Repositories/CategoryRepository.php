<?php

namespace App\Repositories;

use App\Models\Category;

class CategoryRepository extends BaseRepository
{
    /**
     * @inheritDoc
     */
    public function getFieldsSearchable()
    {
        return Category::searchable();
    }

    /**
     * @inheritDoc
     */
    public function model()
    {
        return Category::class;
    }

    public function findOrFail($id)
    {
        return $this->model->findOrFail($id);
    }

}
