<?php

namespace App\Services;

use Illuminate\Contracts\Pagination\LengthAwarePaginator;
use Illuminate\Database\Eloquent\Builder;

abstract class BaseService // template or base that other classes can use
{
    protected function paginate(Builder $query, int $perPage = 10): LengthAwarePaginator
    {
        return $query->latest()->paginate($perPage)->withQueryString();
    }
}
