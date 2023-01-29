<?php

namespace Tests\Unit\Requests;

use App\Http\Requests\PostRequest;
use App\Traits\TestRequest;
use Tests\TestCase;

class PostRequestTest extends TestCase
{
    use TestRequest;

    public function setUp(): void
    {
        parent::setUp();

        $this->rules = (new PostRequest())->rules();
        $this->validator = $this->app['validator'];
    }

    /** @test */
    public function title_field_is_tested()
    {
        $this->testRequiredOnlyField('title');
    }

    /** @test */
    public function description_field_is_tested()
    {
        $this->testRequiredOnlyField('description');
    }

    /** @test */
    public function content_field_is_tested()
    {
        $this->testRequiredOnlyField('content');
    }

    /** @test */
    public function category_id_field_validation_passes()
    {
        $this->assertTrue($this->validateField('category_id', fake()->randomDigitNotZero()));
        $this->assertTrue($this->validateField('category_id', fake()->numberBetween(1)));

        $this->assertFalse($this->validateField('category_id', fake()->word()));
        $this->assertFalse($this->validateField('category_id', fake()->sentence()));
        $this->assertFalse($this->validateField('category_id', fake()->password()));
        $this->assertFalse($this->validateField('category_id', fake()->numberBetween(PHP_INT_MIN, 0)));

        $this->assertFalse($this->validateField('category_id', 0));
    }

    /** @test */
    public function thumbnail_field_validation_passes()
    {
        $this->assertTrue($this->validateField('thumbnail', ''));
        $this->assertTrue($this->validateField('thumbnail', '       '));
        $this->assertTrue($this->validateField('thumbnail', null));

        $this->assertFalse($this->validateField('thumbnail', NAN));
        $this->assertFalse($this->validateField('thumbnail', fake()->word()));
        $this->assertFalse($this->validateField('thumbnail', fake()->sentence()));
        $this->assertFalse($this->validateField('thumbnail', fake()->password()));
        $this->assertFalse($this->validateField('thumbnail', fake()->numberBetween(PHP_INT_MIN, 0)));
    }
}
