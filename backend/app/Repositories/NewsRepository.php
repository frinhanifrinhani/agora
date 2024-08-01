<?php

namespace App\Repositories;

use App\Models\News;
use Illuminate\Support\Facades\Log;

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

    public function findByTitle($title)
    {
        return $this->model->select('id')->where('title', $title)->first();
    }

    public function allQuery($search = [], $skip = null, $limit = null)
    {
        $query = $this->model->newQuery();

        if (count($search)) {
            foreach ($search as $key => $value) {
                if (in_array($key, $this->getFieldsSearchable())) {
                    $query->where($key, $value);
                }
            }
        }

        if (!is_null($skip)) {
            $query->skip($skip);
        }

        if (!is_null($limit)) {
            $query->limit($limit);
        }

        return $query;
    }

    public function paginate($limit, $page, $type = '', $search = [])
    {
        $query = $this->allQuery();

        if ($type) {
            $query->where('type', $type);
        }

        $query->with(['filesNews.file']);
        $query->with(['category']);
        $query->with(['tag']);

        return $query->orderBy('id', 'desc')->paginate($limit, ['*'], 'page', $page);
    }
}