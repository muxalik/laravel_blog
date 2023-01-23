<?php

namespace Tests\Feature\Authentication;

use App\Models\Category;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Support\Facades\Session;
use Tests\TestCase;

class AuthenticationTest extends TestCase
{
    use RefreshDatabase;

    /** @test */
    public function guest_can_access_to_home_page()
    {
        $response = $this->get('/');

        $response->assertStatus(200);
        $response->assertViewIs('posts.index');
    }

    /** @test */
    public function guest_can_access_to_category_page()
    {
        $category = Category::factory()->create();

        $response = $this->get('/category/' . $category->slug);

        $response->assertStatus(200);
        $response->assertViewIs('categories.show');
    }

    /** @test */
    public function guest_can_access_to_contact_page()
    {
        $response = $this->get('/contact');

        $response->assertStatus(200);
        $response->assertViewIs('contact');
    }

    /** @test */
    public function guest_can_access_to_login_page()
    {
        $response = $this->get('/login');

        $response->assertStatus(200);
        $response->assertViewIs('auth.login');
    }

    /** @test */
    public function guest_can_access_to_register_page()
    {
        $response = $this->get('/register');

        $response->assertStatus(200);
        $response->assertViewIs('auth.register');
    }

    /** @test */
    public function authenticated_user_is_redirected_from_register_page()
    {
        $user = User::factory()->create();

        $response = $this->actingAs($user)->get('/register');

        $response->assertStatus(302);
        $response->assertRedirect('/');
    }

    /** @test */
    public function login_redirects_to_home_page_if_default_user()
    {
        Session::start();
        $user = User::create([
            'name' => 'TestName',
            'email' => 'test@mail.com',
            'password' => 'password123'
        ]);

        $response = $this->actingAs($user)->post(
            uri: '/login',
            data: [
                'email' => 'test@mail.com',
                'password' => 'password123'
            ],
            headers: ['X-CSRF-TOKEN' => session()->token()]
        );

        $response->assertStatus(302);
        $response->assertRedirect('/');
    }
}
