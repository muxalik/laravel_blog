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
}