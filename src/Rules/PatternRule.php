<?php

namespace Validator\Rules;

use Validator\Contracts\Rule;

class PatternRule implements Rule
{
    /**
     * Rule name.
     * 
     * @return string
     */
    public function getName(): string
    {
        return 'pattern';
    }

    /**
     * Rule failure message.
     * 
     * @return string
     */
    public function getMessage(): string
    {
        return 'Value does not match the given pattern.';
    }

    /**
     * Check if rule is valid.
     * 
     * @param mixed $value
     * @param mixed $params
     */
    public function validate($value, ...$params): bool
    {
        return preg_match($params[0], $value) === 1;
    }
}