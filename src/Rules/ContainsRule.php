<?php

namespace Validator\Rules;

use Validator\Contracts\Rule;

class ContainsRule implements Rule
{
    /**
     * Rule name.
     * 
     * @return string
     */
    public function getName(): string
    {
        return 'contains';
    }

    /**
     * Rule failure message.
     * 
     * @return string
     */
    public function getMessage(): string
    {
        return 'Value does not contain {0}.';
    }

    /**
     * Check if rule is valid.
     * 
     * @param mixed $value
     * @param mixed $params
     */
    public function validate($value, ...$params): bool
    {
        if (is_string($value)) {
            return str_contains($value, $params[0]) !== false;
        }

        if (is_array($value)) {
            return in_array($params[0], $value);
        }

        if (is_object($value)) {
            return property_exists($value, $params[0]);
        }

        return false;
    }
}