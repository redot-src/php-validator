<?php

namespace Validator\Rules;

use ArgumentCountError;
use Validator\Contracts\Rule;

class MaxRule implements Rule
{
    /**
     * Rule name.
     * 
     * @return string
     */
    public function getName(): string
    {
        return 'max';
    }

    /**
     * Rule failure message.
     * 
     * @return string
     */
    public function getMessage(): string
    {
        return 'Value doesn\'t meet the maximum length of {0}.';
    }

    /**
     * Check if rule is valid.
     * 
     * @param mixed $value
     * @param mixed $params
     */
    public function validate($value, ...$params): bool
    {
        if (count($params) < 1) {
            throw new ArgumentCountError('Max rule requires at least one parameter.');
        }

        if (is_string($value)) {
            return strlen($value) <= $params[0];
        }

        if (is_array($value)) {
            return count($value) <= $params[0];
        }

        return $value <= $params[0];
    }
}