<?php

namespace App\Repositories;

use App\Models\News;
use App\Traits\Paginate;

class NewsRepository extends BaseRepository
{
    use Paginate;

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

    public function searchPaginate(array $filtros = null, $limit = null, array $sort = null)
    {
        $query = $this->model->newQuery();

        if ($filtros) {
            $this->wherePaginate($query, $this->getSearchByFiltros($filtros, ['title']));
        }

        if ($sort) {
            $this->orderPaginate($query, $sort);
        } else {
            $query->orderBy(News::defaultSortAttribute(), 'asc');
        }


        return $query->paginate(
            $limit,
            [
                'id',
                'title',
                'news',
                'status',
                'created_at',
                'updated_at',
            ]
        );
    }

    public function findOrFail($id)
    {
        return $this->model->findOrFail($id);
    }
}
