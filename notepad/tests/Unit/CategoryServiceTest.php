<?php

namespace Tests\Unit;

use App\Models\Category;
use App\Services\CategoryService;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class CategoryServiceTest extends TestCase
{
    use RefreshDatabase;

    protected CategoryService $categoryService;

    protected function setUp(): void
    {
        parent::setUp();

        $this->categoryService = new CategoryService();

        $this->seedCategoriesFromCsv();
    }

    /** @test */
    public function it_returns_all_categories()
    {
        $categories = $this->categoryService->getAllCategories();

        $this->assertCount(3, $categories);

        $this->assertDatabaseHas('categories', [
            'name' => 'Technologie',
        ]);

        $this->assertDatabaseHas('categories', [
            'name' => 'Éducation',
        ]);
    }

    private function seedCategoriesFromCsv(): void
    {
        $path = database_path('seeders/data/categories.csv');

        $rows = array_map('str_getcsv', file($path));
        $header = array_shift($rows);

        foreach ($rows as $row) {
            if (empty(array_filter($row))) {
                continue; // skip empty lines
            }

            $data = array_combine($header, $row);

            Category::create([
                'name' => $data['name'],
                'description' => $data['description'],
            ]);
        }
    }
}
