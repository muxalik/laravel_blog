<?php

namespace Tests\Unit\Models;

use App\Models\Category;
use App\Models\Post;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class CategoryTest extends TestCase
{
    use RefreshDatabase;

    /** @test */ 
    public function it_belongs_to_many_posts()
    {
        $category = $this->createOne();
        Post::factory(3)->create(['category_id' => $category->id]);

        $this->assertEquals(3, $category->posts()->count());
    }
    
    /** @test */
    public function it_is_retrieved_by_slug()
    {
        $category = $this->createOne();
        $actual = Category::getBySlug($category->slug);

        $this->assertTrue($actual->is($category));
    }

    /** @test */
    public function can_get_list()
    {
        $this->createMany();
        $list = Category::getList();

        $list->each(function ($category) {
            $this->assertNotNull([$category->title, $category->slug, $category->posts_count]);
            $this->assertEquals(3, $category->posts_count);
        });

        $this->assertEquals(4, $list->count());
        $this->assertEquals($list->sortByDesc('posts_count'), $list);
    }

    /** @test */
    public function can_get_popular()
    {
        $this->createMany();
        $list = Category::getPopular();

        $list->each(function ($category) {
            $this->assertNotNull($category->title);
            $this->assertEquals(3, $category->posts_count);
        });

        $this->assertEquals(4, $list->count());
        $this->assertEquals($list->sortByDesc('posts_count'), $list);
    }


    private function createOne(): Category
    {
        return Category::factory()->create();
    }

    private function createMany(): void
    {
        Category::factory(4)->create()->each(function ($category) {
            Post::factory(3)->create([
                'category_id' => $category->id
            ]);
        });
    }
}
