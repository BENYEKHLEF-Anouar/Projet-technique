<?php

namespace Tests\Unit;

use Tests\TestCase;
use App\Models\Category;
use App\Services\CategoryService;
use Illuminate\Foundation\Testing\RefreshDatabase; // 1. Use RefreshDatabase

class CategoryServiceTest extends TestCase
{
    use RefreshDatabase; // 2. Ensures a clean notepad_test DB for each run

    protected CategoryService $service;

    protected function setUp(): void
    {
        parent::setUp();
        $this->service = new CategoryService();
    }

    public function test_it_can_get_all_categories()
    {
        // Arrange: Create 5 categories in the empty test database
        Category::factory()->count(5)->create();

        // Act: Call the service method
        $categories = $this->service->getAllCategories();

        // Assert: We expect exactly 5, no more, no less
        $this->assertCount(5, $categories);
        $this->assertInstanceOf(\Illuminate\Support\Collection::class, $categories);
    }
}