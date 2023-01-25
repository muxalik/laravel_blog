<?php

namespace Tests\Unit\Requests;

use App\Http\Requests\ContactRequest;
use App\Traits\TestRequest;
use Tests\TestCase;

class ContactRequestTest extends TestCase
{
    use TestRequest;

    public function setUp(): void
    {
        parent::setUp();

        $this->rules = (new ContactRequest())->rules();
        $this->validator = $this->app['validator'];
    }

    /** @test */
    public function valid_name_passes()
    {
        $this->assertTrue($this->validateField('name', 'jon'));
        $this->assertTrue($this->validateField('name', 'hell123'));
        $this->assertTrue($this->validateField('name', '0'));
        $this->assertTrue($this->validateField('name', '[]'));
        $this->assertTrue($this->validateField('name', '!@#$%^&*()_+|'));
        $this->assertTrue($this->validateField('name', 'New Category 49320'));
        $this->assertTrue($this->validateField('content', fake()->randomNumber()));
    }

    /** @test */
    public function invalid_name_doesnt_pass()
    {
        $this->assertFalse($this->validateField('name', ''));
        $this->assertFalse($this->validateField('name', '    '));
    }

    /** @test */
    public function valid_email_passes()
    {
        for ($i = 0; $i < 10; $i++) {
            $this->assertTrue($this->validateField('email', fake()->email()));
            $this->assertTrue($this->validateField('email', fake()->safeEmail()));
            $this->assertTrue($this->validateField('email', fake()->freeEmail()));
            $this->assertTrue($this->validateField('email', fake()->companyEmail()));
        }
    }

    /** @test */
    public function invalid_email_doesnt_pass()
    {
        $this->assertFalse($this->validateField('email', ''));
        $this->assertFalse($this->validateField('email', '    '));
        $this->assertFalse($this->validateField('email', fake()->password()));
    }

    /** @test */
    public function valid_phone_passes()
    {
        for ($i = 0; $i < 10; $i++) {
            $this->assertTrue($this->validateField('phone', fake()->e164PhoneNumber()));
        }
    }

    /** @test */
    public function invalid_phone_doesnt_pass()
    {
        for ($i = 0; $i < 10; $i++) {
            $this->assertFalse($this->validateField('phone', fake()->word()));
            $this->assertFalse($this->validateField('phone', fake()->text(60)));
        }

        $this->assertFalse($this->validateField('phone', ''));
        $this->assertFalse($this->validateField('phone', '    '));        $this->assertFalse($this->validateField('phone', fake()->password()));
    }

    /** @test */
    public function valid_subject_passes()
    {
        for ($i = 0; $i < 10; $i++) {
            $this->assertTrue($this->validateField('subject', fake()->text(50)));
            $this->assertTrue($this->validateField('subject', fake()->password()));
        }
    }

    /** @test */
    public function invalid_subject_doesnt_pass()
    {
        $this->assertFalse($this->validateField('subject', fake()->sentence(56)));
        
        $this->assertFalse($this->validateField('subject', ''));
        $this->assertFalse($this->validateField('subject', '    '));
    }

    /** @test */
    public function valid_content_passes()
    {
        for ($i = 0; $i < 10; $i++) {
            $this->assertTrue($this->validateField('content', fake()->text(299)));
            $this->assertTrue($this->validateField('content', fake()->password()));
            $this->assertTrue($this->validateField('content', fake()->randomNumber()));
        }
    }

    /** @test */
    public function invalid_content_doesnt_pass()
    {
        $this->assertFalse($this->validateField('content', fake()->sentence(150)));
        
        $this->assertFalse($this->validateField('content', ''));
        $this->assertFalse($this->validateField('content', '    '));
    }
}
