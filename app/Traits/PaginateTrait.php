<?php

namespace App\Traits;

use Illuminate\Contracts\Pagination\LengthAwarePaginator;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Collection;

trait PaginateTrait
{
    private function paginateOrGet(Builder $query): LengthAwarePaginator | Collection
    {
        if (($per_page = intval(request('per_page'))) && $per_page > 0) {
            $data = $query->paginate($per_page);
        } else {
            $data = $query->get();
        }

        return $data;
    }
}
