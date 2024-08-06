<?php

namespace App\Repositories;

use App\Models\Comment;

class CommentRepository extends BaseRepository
{
    /**
     * @inheritDoc
     */
    public function getFieldsSearchable()
    {
        return Comment::searchable();
    }

    /**
     * @inheritDoc
     */
    public function model()
    {
        return Comment::class;
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

        $query->with(['Comment']);

        return $query->orderBy('id', 'desc')->paginate($limit, ['*'], 'page', $page);
    }
}
