<?php

namespace Tests\Unit\Models;

use App\Models\Category;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class CategoryTest extends TestCase
{
    use RefreshDatabase;
    
    public function test_category_can_be_retrieved_using_slug(): void
    {
        $category = Category::factory()->create();
        $this->assertTrue($category->is(Category::getBySlug($category->slug)));
    }
}
