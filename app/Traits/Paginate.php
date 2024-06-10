<?php

namespace App\Traits;

use Illuminate\Database\Eloquent\Builder;

trait Paginate
{
    private function wherePaginate(Builder $query, array $search = [])
    {
        if (key_exists('where_raw', $search)) {
            foreach ($search['where_raw'] as $values) {
                $query->whereRaw(...$values);
            }
        }
        if (key_exists('where', $search)) {
            $query->where($search['where']);
        }
    }

    private function getSearchByFiltros(array $filtros, $likeSearch): array
    {
        $result = [];

        foreach ($filtros as $atributo => $valor) {
            if ($valor === false || !empty($valor)) {
                if (in_array($atributo, $likeSearch)) {
                    $result['where_raw'][] = ["unaccent({$atributo}) ilike unaccent(?)", ["%{$valor}%"]];
                } else {
                    $result['where'][] = [$atributo, $valor];
                }
            }
        }
        return $result;
    }

    private function orderPaginate(Builder $query, array $sort = [])
    {
        foreach ($sort as $value) {
            $query->orderBy($value["key"], $value["order"]);
        }        
    }
}
