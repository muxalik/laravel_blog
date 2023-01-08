<?php

namespace Tests\Unit\Models;

use App\Models\Subscriber;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class SubscriberTest extends TestCase
{
    use RefreshDatabase;

    /** @test */
    public function it_belongs_to_user()
    {
        $user = User::factory()->create();
        $subscriber = Subscriber::factory()->create([
            'user_id' => $user->id,
        ]);
        $user->update(['subscriber_id' => $subscriber->id]);

        $this->assertTrue($user->is($subscriber->user));
    }
}
