<?php

namespace App\Traits;

trait TestRequest {

    protected $validator;
    protected $rules;

    /**
     * Check a field and value against validation rule
     * 
     * @param string $field
     * @param mixed $value
     * @return bool
     */
    protected function validateField(string $field, $value): bool
    {
        return $this->validator->make(
            [$field => $value],
            [$field => $this->rules[$field]]
        )->passes();
    }

    protected function testRequiredOnlyField(string $field)
    {
        $this->assertTrue($this->validateField($field, 'jon'));
        $this->assertTrue($this->validateField($field, 'hell123'));
        $this->assertTrue($this->validateField($field, '0'));
        $this->assertTrue($this->validateField($field, '[]'));
        $this->assertTrue($this->validateField($field, '!@#$%^&*()_+|'));
        $this->assertTrue($this->validateField($field, 'New Category 49320'));
        
        $this->assertFalse($this->validateField($field, ''));
        $this->assertFalse($this->validateField($field, '    '));
    }
}