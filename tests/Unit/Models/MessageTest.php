<?php

namespace Tests\Unit\Models;

use App\Models\Message;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class MessageTest extends TestCase
{
    use RefreshDatabase;

    /** @test */
    public function it_belongs_to_one_user()
    {
        $user = User::factory()->create();
        $message = Message::factory()->create([
            'user_id' => $user->id
        ]);

        $this->assertTrue($user->is($message->user));
    }
}
