<?php

namespace Tests\Unit\Requests;

use App\Http\Requests\LoginRequest;
use App\Traits\TestRequest;
use Tests\TestCase;

class LoginRequestTest extends TestCase
{
    use TestRequest;

    public function setUp(): void
    {
        parent::setUp();

        $this->rules = (new LoginRequest())->rules();
        $this->validator = $this->app['validator'];
    }

    /** @test */
    public function valid_email_passes()
    {
        $this->assertTrue($this->validateField('email', fake()->email()));
        $this->assertTrue($this->validateField('email', fake()->safeEmail()));
        $this->assertTrue($this->validateField('email', fake()->freeEmail()));
        $this->assertTrue($this->validateField('email', fake()->companyEmail()));
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

    /** @test */
    public function valid_password_passes()
    {
        $this->assertTrue($this->validateField('password', fake()->password()));
        $this->assertTrue($this->validateField('password', fake()->word()));
        $this->assertTrue($this->validateField('password', fake()->userName()));
        $this->assertTrue($this->validateField('password', fake()->email()));
    }

    /** @test */
    public function invalid_password_doesnt_pass()
    {
        $this->assertFalse($this->validateField('password', ''));
        $this->assertFalse($this->validateField('password', '    '));
    }
}
