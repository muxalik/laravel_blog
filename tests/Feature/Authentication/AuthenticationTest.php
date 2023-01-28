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

    protected User $user;
    protected User $admin;

    public function setUp(): void
    {
        parent::setUp();

        $this->user = $this->createUser();
        $this->admin = $this->createUser(true);
    }

    protected function createUser(bool $isAdmin = false): User
    {
        return User::factory()->create(['is_admin' => $isAdmin]);
    }

    /** @test */
    public function guest_can_access_home_page()
    {
        $response = $this->get('/');

        $response->assertStatus(200);
        $response->assertViewIs('posts.index');
    }

    /** @test */
    public function guest_can_access_category_page()
    {
        $category = Category::factory()->create();

        $response = $this->get('/category/' . $category->slug);

        $response->assertStatus(200);
        $response->assertViewIs('categories.show');
    }

    /** @test */
    public function guest_can_access_contact_page()
    {
        $response = $this->get('/contact');

        $response->assertStatus(200);
        $response->assertViewIs('contact');
    }

    /** @test */
    public function authenticated_user_is_redirected_from_register_page()
    {
        $response = $this->actingAs($this->user)->get('/register');

        $response->assertStatus(302);
        $response->assertRedirect('/');
    }

    /** @test */
    public function authenticated_user_can_see_logout_link()
    {
        $response = $this->actingAs($this->user)->get('/');

        $response->assertStatus(200);
        $response->assertSee('Logout');
    }

    /** @test */
    public function authenticated_user_can_access_logout_page()
    {
        $response = $this->actingAs($this->user)->get('/logout');

        $response->assertStatus(302);
        $response->assertRedirect('/login');
    }

    /** @test */
    public function guest_cant_see_logout_link()
    {
        $response = $this->get('/');

        $response->assertStatus(200);
        $response->assertDontSee('Logout');
    }

    /** @test */
    public function guest_cant_access_logout_page()
    {
        $response = $this->get('/logout');

        $response->assertStatus(302);
        $response->assertRedirect('/login');
    }

    /** @test */
    public function authenticated_user_cant_see_login_link()
    {
        $response = $this->actingAs($this->user)->get('/');

        $response->assertStatus(200);
        $response->assertDontSee('Login');
    }

    /** @test */
    public function authenticated_user_cant_access_login_page()
    {
        $response = $this->actingAs($this->user)->get('/login');

        $response->assertStatus(302);
        $response->assertRedirect('/');
    }

    /** @test */
    public function guest_can_see_login_link()
    {
        $response = $this->get('/');

        $response->assertStatus(200);
        $response->assertSee('Login');
    }

    /** @test */
    public function guest_can_access_login_page()
    {
        $response = $this->get('/login');

        $response->assertStatus(200);
        $response->assertViewIs('auth.login');
    }

    /** @test */
    public function authenticated_user_cant_see_register_link()
    {
        $response = $this->actingAs($this->user)->get('/');

        $response->assertStatus(200);
        $response->assertDontSee('Register');
    }

    /** @test */
    public function authenticated_user_cant_access_register_page()
    {
        $response = $this->actingAs($this->user)->get('/register');

        $response->assertStatus(302);
        $response->assertRedirect('/');
    }

    /** @test */
    public function guest_can_see_register_link()
    {
        $response = $this->get('/');

        $response->assertStatus(200);
        $response->assertSee('Register');
    }

    /** @test */
    public function guest_can_access_register_page()
    {
        $response = $this->get('/register');

        $response->assertStatus(200);
    }

    /** @test */
    public function guest_cant_see_admin_link()
    {
        $response = $this->get('/');

        $response->assertStatus(200);
        $response->assertDontSee('Admin');
    }

    /** @test */
    public function guest_cant_access_admin_page()
    {
        $response = $this->get('/admin');

        $response->assertStatus(404);
    }

    /** @test */
    public function authenticated_user_cant_see_admin_link()
    {
        $response = $this->actingAs($this->user)->get('/');

        $response->assertStatus(200);
        $response->assertDontSee('Admin');
    }

    /** @test */
    public function authenticated_user_cant_access_admin_page()
    {
        $response = $this->actingAs($this->user)->get('/admin');

        $response->assertStatus(404);
    }

    /** @test */
    public function admin_can_see_admin_link()
    {
        $response = $this->actingAs($this->admin)->get('/');

        $response->assertStatus(200);
        $response->assertSee('Admin');
    }

    /** @test */
    public function admin_can_access_admin_page()
    {
        $response = $this->actingAs($this->admin)->get('/admin');

        $response->assertStatus(200);
    }

    /** @test */
    public function user_is_redirected_to_home_page_if_is_not_admin()
    {
        Session::start();
        $password = 'password123';
        $user = User::factory()->create(['password' => 'password123']);

        $response = $this->post(
            uri: '/login',
            data: [
                'email' => $user->email,
                'password' => $password
            ],
            headers: ['X-CSRF-TOKEN' => session()->token()]
        );

        $response->assertStatus(302);
        $response->assertRedirect('/');
    }

    /** @test */
    public function user_cant_pass_authentication()
    {
        Session::start();

        $response = $this->post(
            uri: '/login',
            data: [
                'email' => $this->user->email,
                'password' => 'password123'
            ],
            headers: ['X-CSRF-TOKEN' => session()->token()]
        );

        $response->assertStatus(302);
        $response->assertRedirect('/login');
        $response->assertSessionHas('error');
    }

    /** @test */
    public function user_is_redirected_to_admin_page_if_is_admin()
    {
        Session::start();
        $password = 'adminpass123';
        $admin = User::factory()->create([
            'password' => $password,
            'is_admin' => 1
        ]);

        $response = $this->post(
            uri: '/login',
            data: [
                'email' => $admin->email,
                'password' => $password
            ],
            headers: ['X-CSRF-TOKEN' => session()->token()]
        );

        $response->assertStatus(302);
        $response->assertRedirect('/admin');
    }

    /** @test */
    public function user_is_redirected_after_registration()
    {
        Session::start();
        $password = 'adminpass123';

        $response = $this->post(
            uri: '/register',
            data: [
                'name' => fake()->userName(),
                'email' => fake()->email(),
                'password' => $password,
                'password_confirmation' => $password
            ],
            headers: ['X-CSRF-TOKEN' => session()->token()]
        );

        $response->assertStatus(302);
        $response->assertRedirect('/');
    }
}
