<?php

namespace App\Repositories;

use App\Models\Noticia;
use App\Traits\Paginate;

class NoticiaRepository extends BaseRepository
{
    use Paginate;

    /**
     * @inheritDoc
     */
    public function getFieldsSearchable()
    {
        return Noticia::searchable();
    }

    /**
     * @inheritDoc
     */
    public function model()
    {
        return Noticia::class;
    }

    public function searchPaginate(array $filtros = null, $limit = null, array $sort = null)
    {
        $query = $this->model->newQuery();

        if ($filtros) {
            $this->wherePaginate($query, $this->getSearchByFiltros($filtros, ['titulo']));
        }

        if ($sort) {
            $this->orderPaginate($query, $sort);
        } else {
            $query->orderBy(Noticia::defaultSortAttribute(), 'asc');
        }


        return $query->paginate(
            $limit,
            [
                'id',
                'titulo',
                'noticia',
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
