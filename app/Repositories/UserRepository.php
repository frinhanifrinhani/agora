<?php

namespace App\Repositories;

use App\Models\User;

class UserRepository extends BaseRepository
{
    /**
     * @inheritDoc
     */
    public function getFieldsSearchable()
    {
        return User::searchable();
    }

    /**
     * @inheritDoc
     */
    public function model()
    {
        return User::class;
    }

    public function findOrFail($id)
    {
        return $this->model->findOrFail($id);
    }

}
