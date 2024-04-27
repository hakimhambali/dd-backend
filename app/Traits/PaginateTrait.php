<?php

namespace App\Traits;

use Illuminate\Contracts\Pagination\LengthAwarePaginator;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Collection;

trait PaginateTrait
{
    private function paginateOrGet(Builder $query): LengthAwarePaginator | Collection
    {
        if (($perPage = intval(request('per_page'))) && $perPage > 0) {
            $data = $query->paginate($perPage);
        } else {
            $data = $query->get();
        }

        return $data;
    }
}
