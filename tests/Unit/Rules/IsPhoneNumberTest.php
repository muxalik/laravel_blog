<?php

namespace Tests\Unit\Rules;

use App\Rules\IsPhoneNumber;
use Tests\TestCase;

class IsPhoneNumberTest extends TestCase
{
    protected IsPhoneNumber $rule;

    public function setUp(): void 
    {
        parent::setUp();

        $this->rule = new IsPhoneNumber();
    }

    public function invalidData(): array
    {
        return [
            [''],
            ['Some text...'],
            ['345132'],
            ['18408605472833534'],
            ['Text34553854'],
            ['4579457963text'],
            ['543-545------34-4'],
            ['  54874875464'],
            ['85834895943     '],
            ['8  9 798 79 7 798 7'],
            ['-4174837247'],
            ['3u503475753'],
            ['053 58340 24-74']
        ];
    }

    public function validData(): array
    {
        return [
            ['+79261234567'],
            ['89261234567'],
            ['79261234567'],
            ['39261234567'],
            ['19261234567'],
            ['+7 926 123 45 67'],
            ['8(926)123-45-67'],
            ['123-45-67'],
            ['9261234567'],
            ['79261234567'],
            ['(495)1234567'],
            ['(495) 123 45 67'],
            ['59261234567'],
            ['8-926-123-45-67'],
            ['8 927 1234 234'],
            ['8 927 12 12 888'],
            ['8 927 12 555 12'],
            ['8 927 123 8 123'],
        ];
    }

    /** 
     * @test
     * @dataProvider invalidData 
     */
    public function invalid_data_validation_fails(string $phoneNumber)
    {
        $this->assertFalse(boolval($this->rule->passes('test', $phoneNumber)));
    }

    /** 
     * @test
     * @dataProvider validData 
     */
    public function valid_data_validation_fails(string $phoneNumber)
    {
        $this->assertTrue(boolval($this->rule->passes('test', $phoneNumber)));
    }
}
