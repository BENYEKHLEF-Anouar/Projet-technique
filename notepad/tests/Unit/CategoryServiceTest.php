<?php

namespace Tests\Unit;

use Tests\TestCase;
use App\Services\CategoryService;
use Illuminate\Foundation\Testing\DatabaseTransactions;

class CategoryServiceTest extends TestCase
{
    use DatabaseTransactions;

    protected CategoryService $service;

    protected function setUp(): void
    {
        parent::setUp();
        $this->service = new CategoryService();
    }

    public function test_it_can_get_all_categories()
    {
        $categories = $this->service->getAllCategories();

        $this->assertGreaterThan(0, $categories->count());
    }
}
