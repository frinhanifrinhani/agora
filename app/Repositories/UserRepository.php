<?php

namespace App\Repositories;

use App\Models\User;
use App\Traits\Paginate;

class UserRepository extends BaseRepository
{
    use Paginate;

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

    public function searchPaginate(array $filtros = null, $limit = null, array $sort = null)
    {
        $query = $this->model->newQuery();

        if ($filtros) {
            $this->wherePaginate($query, $this->getSearchByFiltros($filtros, ['name']));
        }

        if ($sort) {
            $this->orderPaginate($query, $sort);
        } else {
            $query->orderBy(User::defaultSortAttribute(), 'asc');
        }

        return $query->paginate(
            $limit,
            [
                'id',
                'cpf',
                'name',
                'email',
                'phone',
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
