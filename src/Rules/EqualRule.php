<?php

namespace Validator\Rules;

use ArgumentCountError;
use Validator\Contracts\Rule;

class EqualRule implements Rule
{
    /**
     * Rule name.
     * 
     * @return string
     */
    public function getName(): string
    {
        return 'equal';
    }

    /**
     * Rule failure message.
     * 
     * @return string
     */
    public function getMessage(): string
    {
        return 'Value should be equal to {0}.';
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
            throw new ArgumentCountError('Equal rule requires at least one parameter.');
        }

        return $value == $params[0];
    }
}