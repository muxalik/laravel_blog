<?php

namespace Tests\Unit\Requests;

use App\Http\Requests\CommentRequest;
use App\Traits\TestRequest;
use Tests\TestCase;

class CommentRequestTest extends TestCase
{
    use TestRequest;

    public function setUp(): void
    {
        parent::setUp();

        $this->rules = (new CommentRequest())->rules();
        $this->validator = $this->app['validator'];
    }

    /** @test */
    public function valid_content_passes()
    {
        $this->assertTrue($this->validateField('content', 'jon'));
        $this->assertTrue($this->validateField('content', 'hell123'));
        $this->assertTrue($this->validateField('content', '0'));
        $this->assertTrue($this->validateField('content', '[]'));
        $this->assertTrue($this->validateField('content', '!@#$%^&*()_+|'));
        $this->assertTrue($this->validateField('content', 'New Comment 49320'));
    }

    /** @test */
    public function invalid_content_doesnt_pass()
    {
        $this->assertFalse($this->validateField('content', ''));
        $this->assertFalse($this->validateField('content', '    '));
    }
}
