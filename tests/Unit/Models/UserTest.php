<?php

namespace Tests\Unit\Models;

use App\Models\Subscriber;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Hash;
use Tests\TestCase;

class UserTest extends TestCase
{
    use RefreshDatabase;

    /** @test */
    public function it_has_subscriber()
    {
        $user = User::factory()->create();
        $subscriber = Subscriber::factory()->create([
            'user_id' => $user->id
        ]);

        $user->update(['subscriber_id' => $subscriber->id]);

        $this->assertTrue($subscriber->is($user->subscriber));
    }

    /** @test */
    public function its_password_is_encrypted()
    {
        $password = 'Hello Kitty!';
        $user = User::factory()->create(['password' => $password]);

        $this->assertTrue(Hash::check($password, $user->password));
    }
}
