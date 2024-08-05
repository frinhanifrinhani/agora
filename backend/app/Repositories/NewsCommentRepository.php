<?php

namespace App\Repositories;

use App\Models\NewsComment;

class NewsCommentRepository extends BaseRepository
{
    /**
     * @inheritDoc
     */
    public function getFieldsSearchable()
    {
        return NewsComment::searchable();
    }

    /**
     * @inheritDoc
     */
    public function model()
    {
        return NewsComment::class;
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

        $query->with(['NewsComment']);

        return $query->orderBy('id', 'desc')->paginate($limit, ['*'], 'page', $page);
    }
}
