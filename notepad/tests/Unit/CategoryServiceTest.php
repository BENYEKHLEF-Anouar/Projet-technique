<?php

namespace Tests\Unit;

use Tests\TestCase;
use App\Models\Category;
use App\Services\CategoryService;
use Illuminate\Foundation\Testing\RefreshDatabase;

class CategoryServiceTest extends TestCase
{
    use RefreshDatabase;

    public function test_it_can_get_all_categories()
    {
        // Arrange
        Category::create([
            'name' => 'Technologie',
            'description' => 'Tout sur la technologie',
        ]);

        Category::create([
            'name' => 'Style de vie',
            'description' => 'Vie quotidienne et conseils',
        ]);

        Category::create([
            'name' => 'Éducation',
            'description' => 'Apprentissage et connaissances',
        ]);

        $service = new CategoryService();

        // Act
        $result = $service->getAllCategories();

        // Assert
        $this->assertCount(3, $result);

        $this->assertDatabaseHas('categories', [
            'name' => 'Technologie',
        ]);

        $this->assertDatabaseHas('categories', [
            'name' => 'Éducation',
        ]);
    }
}
