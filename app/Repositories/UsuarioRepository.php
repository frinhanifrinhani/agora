<?php

namespace App\Repositories;

use App\Models\Usuario;
use App\Traits\Paginate;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;

class UsuarioRepository extends BaseRepository
{
    use Paginate;

    /**
     * @inheritDoc
     */
    public function getFieldsSearchable()
    {
        return Usuario::searchable();
    }

    /**
     * @inheritDoc
     */
    public function model()
    {
        return Usuario::class;
    }

    public function searchPaginate(array $filtros = null, $limit = null, array $sort = null)
    {
        $query = $this->model->newQuery();

        if ($filtros) {
            $this->wherePaginate($query, $this->getSearchByFiltros($filtros, ['nome']));
        }

        if ($sort) {
            $this->orderPaginate($query, $sort);
        } else {
            $query->orderBy(Usuario::deafultSortAttribute(), 'asc');
        }

        return $query->paginate(
            $limit,
            [
                'id',
                'cpf',
                'nome',
                'email',
                'telefone',
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
