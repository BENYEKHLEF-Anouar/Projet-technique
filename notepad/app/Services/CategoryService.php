<?php

namespace App\Services;

use App\Models\Category;
use Illuminate\Database\Eloquent\Collection;

class CategoryService extends BaseService
{
    /**
     * Get all categories.
     *
     * @return Collection
     */
    public function getAll(): Collection
    {
        return Category::all();
    }

    /**
     * Create a new category.
     *
     * @param array $data
     * @return Category
     */
    public function create(array $data): Category
    {
        return Category::create($data);
    }

    /**
     * Update a category.
     *
     * @param Category $category
     * @param array $data
     * @return bool
     */
    public function update(Category $category, array $data): bool
    {
        return $category->update($data);
    }

    /**
     * Delete a category.
     *
     * @param Category $category
     * @return bool|null
     */
    public function delete(Category $category): ?bool
    {
        return $category->delete();
    }
}
