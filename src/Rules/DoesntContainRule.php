<?php

namespace Validator\Rules;

use ArgumentCountError;
use Validator\Contracts\Rule;

class DoesntContainRule implements Rule
{
    /**
     * Rule name.
     * 
     * @return string
     */
    public function getName(): string
    {
        return 'doesntContain';
    }

    /**
     * Rule failure message.
     * 
     * @return string
     */
    public function getMessage(): string
    {
        return 'Value contains {0}.';
    }

    /**
     * Check if rule is valid.
     * 
     * @param mixed $value
     * @param mixed $params
     *
     * @throws ArgumentCountError
     */
    public function validate($value, ...$params): bool
    {
        if (count($params) < 1) {
            throw new ArgumentCountError('DoesntContain rule requires at least one parameter.');
        }

        foreach ($params as $param) {
            if (is_string($value)) {
                return !str_contains($value, $param);
            }

            if (is_array($value)) {
                return !in_array($param, $value);
            }

            if (is_object($value)) {
                return !property_exists($value, $param);
            }

            return false;
        }
    }
}