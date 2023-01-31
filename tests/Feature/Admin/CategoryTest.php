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
    use RefreshDatabase;

    protected User $admin;

    public function setUp(): void
    {
        parent::setUp();

        $this->admin = User::factory()->create(['is_admin' => 1]);
        Session::start();
    }

    /** @test */
    public function admin_can_access_categories_index_page()
    {
        Category::factory(4)->create();

        $response = $this->actingAs($this->admin)
            ->get('/admin/categories');

        $response->assertStatus(200);
    }

    /** @test */
    public function admin_can_see_categories_index_page()
    {
        $categories = Category::factory(4)->create();

        $response = $this->actingAs($this->admin)
            ->get(uri: '/admin/categories');

        $response->assertStatus(200);
        $response->assertSee('Список категорий');
        $response->assertViewHas('categories', $categories);
        $categories->each(function ($category) use ($response) {
            $response->assertSee($category->title);
            $response->assertSee($category->slug);
        });
    }

    /** @test */
    public function admin_can_see_categories_page_links()
    {
        $response = $this->actingAs($this->admin)->get('/admin');

        $response->assertStatus(200);
        $response->assertSee(route('categories.index'));
        $response->assertSee('Список категорий');
        $response->assertSee(route('categories.create'));
        $response->assertSee('Новая категория');
    }

    /** @test */
    public function admin_can_see_action_links()
    {
        $categories = Category::factory(4)->create();
        $response = $this->actingAs($this->admin)->get(route('categories.index'));

        $response->assertStatus(200);
        $response->assertSee('Добавить категорию');
        $response->assertSee(route('categories.create'));
        $response->assertSee('Обновить');
        $response->assertSee(route('categories.refresh'));
        $response->assertSee('Удалить все категории');
        $response->assertSee(route('categories.destroy', ['category' => 'all']));
        
        $categories->each(function ($category) use ($response) {
            $response->assertSee(route('categories.edit', ['category' => $category->id]));
            $response->assertSee(route('categories.destroy', ['category' => $category->id]));
        });
    }

    /** @test */
    public function delete_one_when_exists()
    {
        $category = Category::factory()->create();

        $response = $this->actingAs($this->admin)->delete(
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
        $response = $this->actingAs($this->admin)->delete(
            uri: '/admin/categories/4',
            headers: ['X-CSRF-TOKEN' => session()->token()]
        );

        $response->assertStatus(404);
    }

    /** @test */
    public function delete_one_when_related_posts_exist()
    {
        $category = Category::factory()->create();
        Post::factory(4)->create(['category_id' => $category->id]);

        $response = $this->actingAs($this->admin)->delete(
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
        $category = Category::factory()->create();

        $response = $this->actingAs($this->admin)->delete(
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
        $response = $this->actingAs($this->admin)->delete(
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
        Category::factory(4)->create();

        $response = $this->actingAs($this->admin)->delete(
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
        $categories = Category::factory(4)->create();
        Post::factory(6)->create(['category_id' => $categories->random()->id]);

        $response = $this->actingAs($this->admin)->delete(
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
        Category::factory(4)->create();

        $response = $this->actingAs($this->admin)->delete(
            uri: '/admin/categories/all',
            headers: ['X-CSRF-TOKEN' => session()->token()]
        );

        $response->assertStatus(302);
        $response->assertRedirect('admin/categories');
        $response->assertSessionHas('success');
        $this->assertDatabaseCount('categories', 0);
    }

    /** @test */
    public function category_edit_contains_correct_values()
    {
        $category = Category::factory()->create();

        $response = $this->actingAs($this->admin)
            ->get('/admin/categories/' . $category->id . '/edit');

        $response->assertStatus(200);
        $response->assertSee('value="' . $category->title . '"', false);
        $response->assertViewHas('category');
    }

    /** @test */
    public function category_update_validation_error_redirects_back_to_form()
    {
        $category = Category::factory()->create();
        $url = route('categories.edit', ['category' => $category->id]);

        $response = $this->actingAs($this->admin)->from($url)->put(
            uri: route('categories.update', ['category' => $category->id]),
            data: ['title' => ''],
            headers: ['X-CSRF-TOKEN' => session()->token()]
        );

        $response->assertStatus(302);
        $response->assertRedirect($url);
        $response->assertInvalid(['title']);
    }

    /** @test */
    public function category_update_and_redirects_to_categories_index_page()
    {
        $category = Category::factory()->create();
        $title = 'New Name 123';

        $response = $this->actingAs($this->admin)
            ->from(route('categories.edit', ['category' => $category->id]))->put(
            uri: route('categories.update', ['category' => $category->id]),
            data: ['title' => $title],
            headers: ['X-CSRF-TOKEN' => session()->token()]
        );

        $response->assertStatus(302);
        $response->assertSessionHasNoErrors();
        $response->assertRedirect(route('categories.index'));
        $this->assertDatabaseHas('categories', ['title' => $title]);
    }
}
