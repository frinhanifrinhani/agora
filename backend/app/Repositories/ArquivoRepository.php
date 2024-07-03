<?php

namespace App\Repositories;

use App\Models\Arquivo;

class ArquivoRepository extends BaseRepository
{
    /**
     * @inheritDoc
     */
    public function getFieldsSearchable()
    {
        return Arquivo::searchable();
    }

    /**
     * @inheritDoc
     */
    public function model()
    {
        return Arquivo::class;
    }

    public function findOrFail($id)
    {
        return $this->model->findOrFail($id);
    }
}
