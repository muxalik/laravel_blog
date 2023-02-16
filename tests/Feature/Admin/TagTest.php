<?php

namespace Tests\Feature\Admin;

use App\Models\Post;
use App\Models\Tag;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Support\Facades\Session;
use Tests\TestCase;

class TagTest extends TestCase
{
    use RefreshDatabase;

    protected User $admin;
    protected User $user;

    public function setUp(): void
    {
        parent::setUp();

        Session::start();
        $this->admin = User::factory()->create(['is_admin' => 1]);
        $this->user = User::factory()->create(['is_admin' => 0]);
    }

    /** @test */
    public function admin_can_access_index_page()
    {
        $tags = Tag::factory(10)->create();
        $posts = Post::factory(3)->create();
        $posts->each(function (Post $post) use ($tags) {
            $post->tags()->sync($tags->random(rand(1, 10)));
        });

        $response = $this->actingAs($this->admin)->get('/admin/tags');
        
        $response->assertOk();
        $response->assertSee('Список тегов');
        $response->assertViewHas('tags');
        $response->assertViewIs('admin.tags.index');
        $tags->each(function (Tag $tag) use ($response) {
            $response->assertSee(route('tags.edit', ['tag' => $tag->id]));
            $response->assertSee(route('tags.destroy', ['tag' => $tag->id]));
            $response->assertSee($tag->id);
            $response->assertSee($tag->title);
            $response->assertSee($tag->slug);
            $response->assertSee($tag->posts->count());
        });
    }

    /** @test */
    public function admin_can_access_create_page()
    {
        $response = $this->actingAs($this->admin)->get('/admin/tags/create');

        $response->assertOk();
        $response->assertViewIs('admin.tags.create');
    }

    /** @test */
    public function admin_can_access_edit_page()
    {
        $tag = Tag::factory()->create();

        $response = $this->actingAs($this->admin)->get('/admin/tags/' . $tag->id . '/edit');

        $response->assertOk();
        $response->assertViewIs('admin.tags.edit');
        $response->assertSee($tag->title);
    }

    /** @test */
    public function non_admin_cant_access_index_page_gets_404()
    {
        $response = $this->actingAs($this->user)->get('/admin/tags');

        $response->assertStatus(404);
    }

    /** @test */
    public function non_admin_cant_access_create_page_gets_404()
    {
        $response = $this->actingAs($this->user)->get('/admin/tags/create');

        $response->assertStatus(404);
    }
    
    /** @test */
    public function non_admin_cant_access_edit_page_gets_404()
    {
        $tag = Tag::factory()->create();

        $response = $this->actingAs($this->user)->get('/admin/tags/' . $tag->id . '/edit');

        $response->assertStatus(404);
    }

    /** @test */
    public function tag_update_validation_error_redirects_back_to_form()
    {
        $tag = Tag::factory()->create();
        $url = route('tags.edit', ['tag' => $tag->id]);

        $response = $this->actingAs($this->admin)->from($url)->put(
            uri: '/admin/tags/' . $tag->id,
            data: ['title' => ''],
            headers: ['X-CSRF-TOKEN' => session()->token()]);

        $response->assertStatus(302);
        $response->assertRedirect($url);
        $response->assertInvalid(['title']);
        $this->assertDatabaseHas('tags', ['id' => $tag->id, 'title' => $tag->title]);
    }

    /** @test */
    public function tag_update_and_redirects_to_index_page()
    {
        $tag = Tag::factory()->create();

        $response = $this->actingAs($this->admin)
            ->from(route('tags.edit', ['tag' => $tag->id]))
            ->put(
                uri: '/admin/tags/' . $tag->id,
                data: ['title' => 'new title'],
                headers: ['X-CSRF-TOKEN' => session()->token()]
            );

        $response->assertStatus(302);
        $response->assertRedirect(route('tags.index'));
        $response->assertSessionHas('success');
        $this->assertDatabaseHas('tags', ['id' => $tag->id, 'title' => 'new title']);
    }

    /** @test */
    public function delete_one_when_exists()
    {
        $tag = Tag::factory()->create();

        $response = $this->actingAs($this->admin)->delete(
            uri: '/admin/tags/' . $tag->id,
            headers: ['X-CSRF-TOKEN' => session()->token()]
        );

        $response->assertStatus(302);
        $response->assertRedirect('/admin/tags');
        $response->assertSessionHas('success');
        $this->assertModelMissing($tag);
    }

    /** @test */
    public function delete_one_when_doesnt_exist()
    {
        $response = $this->actingAs($this->admin)->delete(
            uri: '/admin/tags/4',
            headers: ['X-CSRF-TOKEN' => session()->token()]
        );

        $response->assertStatus(404);
    }

    /** @test */
    public function delete_one_when_related_posts_exist()
    {
        $tag = Tag::factory()->create();
        $posts = Post::factory(7)->create();
        $tag->posts()->sync($posts);

        $response = $this->actingAs($this->admin)->delete(
            uri: '/admin/tags/' . $tag->id,
            headers: ['X-CSRF-TOKEN' => session()->token()]
        );

        $response->assertStatus(302);
        $response->assertRedirect('admin/tags');
        $response->assertSessionHas('error');
        $this->assertModelExists($tag);
    }

    /** @test */
    public function delete_one_when_related_posts_dont_exist()
    {
        $tag = Tag::factory()->create();

        $response = $this->actingAs($this->admin)->delete(
            uri: '/admin/tags/' . $tag->id,
            headers: ['X-CSRF-TOKEN' => session()->token()]
        );

        $response->assertStatus(302);
        $response->assertRedirect('admin/tags');
        $response->assertSessionHas('success');
        $this->assertModelMissing($tag);
    }

    /** @test */
    public function delete_all_when_dont_exist()
    {
        $response = $this->actingAs($this->admin)->delete(
            uri: '/admin/tags/all',
            headers: ['X-CSRF-TOKEN' => session()->token()]
        );

        $response->assertStatus(302);
        $response->assertRedirect('admin/tags');
        $response->assertSessionHas('error');
    }

    /** @test */
    public function delete_all_when_exist()
    {
        Tag::factory(4)->create();

        $response = $this->actingAs($this->admin)->delete(
            uri: '/admin/tags/all',
            headers: ['X-CSRF-TOKEN' => session()->token()]
        );

        $response->assertStatus(302);
        $response->assertRedirect('admin/tags');
        $response->assertSessionHas('success');
        $this->assertDatabaseCount('tags', 0);
    }

    /** @test */
    public function delete_all_when_related_posts_exist()
    {
        $tags = Tag::factory(4)->create();
        $posts = Post::factory(6)->create();
        $posts->each(function ($post) use ($tags) {
            $post->tags()->sync($tags->random(3));
        });

        $response = $this->actingAs($this->admin)->delete(
            uri: '/admin/tags/all',
            headers: ['X-CSRF-TOKEN' => session()->token()]
        );

        $response->assertStatus(302);
        $response->assertRedirect('admin/tags');
        $response->assertSessionHas('error');
        $this->assertDatabaseCount('tags', 4);
    }

    /** @test */
    public function delete_all_when_related_posts_doesnt_exist()
    {
        Tag::factory(4)->create();

        $response = $this->actingAs($this->admin)->delete(
            uri: '/admin/tags/all',
            headers: ['X-CSRF-TOKEN' => session()->token()]
        );

        $response->assertStatus(302);
        $response->assertRedirect('admin/tags');
        $response->assertSessionHas('success');
        $this->assertDatabaseCount('tags', 0);
    }
}
