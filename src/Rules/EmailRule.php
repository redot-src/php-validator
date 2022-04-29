<?php

namespace Validator\Rules;

use Validator\Contracts\Rule;

class EmailRule implements Rule
{
    /**
     * Rule name.
     * 
     * @return string
     */
    public function getName(): string
    {
        return 'email';
    }

    /**
     * Rule failure message.
     * 
     * @return string
     */
    public function getMessage(): string
    {
        return 'Value is not a valid email address.';
    }

    /**
     * Check if rule is valid.
     * 
     * @param mixed $value
     * @param mixed $params
     */
    public function validate($value, ...$params): bool
    {
        return filter_var($value, FILTER_VALIDATE_EMAIL) !== false;
    }
}