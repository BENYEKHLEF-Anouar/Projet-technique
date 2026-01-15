<?php

namespace App\Services;

use Illuminate\Contracts\Pagination\LengthAwarePaginator;
use Illuminate\Database\Eloquent\Builder;

abstract class BaseService
{
    protected int $perPage = 10;

    protected function paginate(Builder $query, ?int $perPage = null): LengthAwarePaginator
    {
        return $query->latest()->paginate($perPage ?? $this->perPage)->withQueryString();
    }
}
