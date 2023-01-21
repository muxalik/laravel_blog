<?php

namespace Tests\Feature\Admin;

use App\Models\Category;
use App\Models\Post;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Support\Facades\Session;
use Tests\TestCase;

class CategoryTest extends TestCase
{
    public function tearDown(): void
    {
        Post::truncate();
        Category::truncate();
        parent::tearDown();
    }

    /** @test */
    public function delete_one_when_exists()
    {
        Session::start();
        $user = User::factory()->create(['is_admin' => 1]);
        $category = Category::factory()->create();

        $response = $this->actingAs($user)->delete(
            uri: '/admin/categories/' . $category->id,
            headers: ['X-CSRF-TOKEN' => session()->token()]
        );

        $response->assertStatus(302);
        $response->assertRedirect('admin/categories');
        $response->assertSessionHas('success');
        $this->assertModelMissing($category);
    }

    /** @test */
    public function delete_one_when_doesnt_exists()
    {
        Session::start();
        $user = User::factory()->create(['is_admin' => 1]);

        $response = $this->actingAs($user)->delete(
            uri: '/admin/categories/4',
            headers: ['X-CSRF-TOKEN' => session()->token()]
        );

        $response->assertStatus(404);
    }

    /** @test */
    public function delete_one_when_related_posts_exist()
    {
        Session::start();
        $user = User::factory()->create(['is_admin' => 1]);
        $category = Category::factory()->create();
        Post::factory(4)->create(['category_id' => $category->id]);

        $response = $this->actingAs($user)->delete(
            uri: '/admin/categories/' . $category->id,
            headers: ['X-CSRF-TOKEN' => session()->token()]
        );

        $response->assertStatus(302);
        $response->assertRedirect('admin/categories');
        $response->assertSessionHas('error');
        $this->assertModelExists($category);
    }

    /** @test */
    public function delete_one_when_related_posts_dont_exist()
    {
        Session::start();
        $user = User::factory()->create(['is_admin' => 1]);
        $category = Category::factory()->create();

        $response = $this->actingAs($user)->delete(
            uri: '/admin/categories/' . $category->id,
            headers: ['X-CSRF-TOKEN' => session()->token()]
        );

        $response->assertStatus(302);
        $response->assertRedirect('admin/categories');
        $response->assertSessionHas('success');
        $this->assertModelMissing($category);
    }

    /** @test */
    public function delete_all_when_dont_exist()
    {
        Session::start();
        $user = User::factory()->create(['is_admin' => 1]);

        $response = $this->actingAs($user)->delete(
            uri: '/admin/categories/all',
            headers: ['X-CSRF-TOKEN' => session()->token()]
        );

        $response->assertStatus(302);
        $response->assertRedirect('admin/categories');
        $response->assertSessionHas('error');
    }

    /** @test */
    public function delete_all_when_exist()
    {
        Session::start();
        $user = User::factory()->create(['is_admin' => 1]);
        Category::factory(4)->create();

        $response = $this->actingAs($user)->delete(
            uri: '/admin/categories/all',
            headers: ['X-CSRF-TOKEN' => session()->token()]
        );

        $response->assertStatus(302);
        $response->assertRedirect('admin/categories');
        $response->assertSessionHas('success');
        $this->assertDatabaseCount('categories', 0);
    }

    /** @test */
    public function delete_all_when_related_posts_exist()
    {
        Session::start();
        $user = User::factory()->create(['is_admin' => 1]);
        $categories = Category::factory(4)->create();
        Post::factory(6)->create(['category_id' => $categories->random()->id]);

        $response = $this->actingAs($user)->delete(
            uri: '/admin/categories/all',
            headers: ['X-CSRF-TOKEN' => session()->token()]
        );

        $response->assertStatus(302);
        $response->assertRedirect('admin/categories');
        $response->assertSessionHas('error');
        $this->assertDatabaseCount('categories', 4);
    }

    /** @test */
    public function delete_all_when_related_posts_doesnt_exist()
    {
        Session::start();
        $user = User::factory()->create(['is_admin' => 1]);
        Category::factory(4)->create();

        $response = $this->actingAs($user)->delete(
            uri: '/admin/categories/all',
            headers: ['X-CSRF-TOKEN' => session()->token()]
        );

        $response->assertStatus(302);
        $response->assertRedirect('admin/categories');
        $response->assertSessionHas('success');
        $this->assertDatabaseCount('categories', 0);
    }
}
