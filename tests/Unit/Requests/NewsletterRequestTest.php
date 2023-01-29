<?php

namespace Tests\Unit\Requests;

use App\Http\Requests\NewsletterRequest;
use App\Models\User;
use App\Traits\TestRequest;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class NewsletterRequestTest extends TestCase
{
    use TestRequest, RefreshDatabase;

    public function setUp(): void
    {
        parent::setUp();

        $this->rules = (new NewsletterRequest())->rules();
        $this->validator = $this->app['validator'];
    }

    /** @test */
    public function valid_email_passes()
    {
        $emails = [fake()->email(), fake()->safeEmail(), fake()->freeEmail(), fake()->companyEmail()];

        foreach ($emails as $email) {
            $this->assertTrue($this->validateField('email', $email));
            $this->assertDatabaseMissing('subscribers', ['email' => $email]);
        }

        User::factory(10)->create()->each(function ($user) {
            $this->assertTrue($this->validateField('email', $user->email));
        });
    }

    /** @test */
    public function invalid_email_doesnt_pass()
    {
        $this->assertFalse($this->validateField('email', ''));
        $this->assertFalse($this->validateField('email', '    '));
        $this->assertFalse($this->validateField('email', fake()->password()));
        $this->assertFalse($this->validateField('email', fake()->word()));
        $this->assertFalse($this->validateField('email', fake()->text(50)));
        $this->assertFalse($this->validateField('email', fake()->sentence(10)));
    }
}
