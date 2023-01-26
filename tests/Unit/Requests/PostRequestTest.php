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
}
