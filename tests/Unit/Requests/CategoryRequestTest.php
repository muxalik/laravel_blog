<?php

namespace Tests\Unit\Requests;

use App\Http\Requests\CategoryRequest;
use App\Traits\TestRequest;
use Tests\TestCase;

class CategoryRequestTest extends TestCase
{
    use TestRequest;

    public function setUp(): void
    {
        parent::setUp();

        $this->rules = (new CategoryRequest())->rules();
        $this->validator = $this->app['validator'];
    }

    /** @test */
    public function valid_title_passes()
    {
        $this->assertTrue($this->validateField('title', 'jon'));
        $this->assertTrue($this->validateField('title', 'hell123'));
        $this->assertTrue($this->validateField('title', '0'));
        $this->assertTrue($this->validateField('title', '[]'));
        $this->assertTrue($this->validateField('title', '!@#$%^&*()_+|'));
        $this->assertTrue($this->validateField('title', 'New Category 49320'));
    }

    /** @test */
    public function invalid_title_doesnt_pass()
    {
        $this->assertFalse($this->validateField('title', ''));
        $this->assertFalse($this->validateField('title', '    '));
    }
}
