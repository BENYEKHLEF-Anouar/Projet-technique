<?php

namespace App\Services;

use App\Models\Category;
use Illuminate\Database\Eloquent\Collection;

class CategoryService extends BaseService
{
    public function getAllCategories(): Collection
    {
        return Category::all();
    }
}
