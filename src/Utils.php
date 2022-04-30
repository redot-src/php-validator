<?php

namespace Validator;

use Stringable;

class Utils
{
    /**
     * Check if value can be casted to string.
     *
     * @param mixed $value
     * @return bool
     */
    public static function canBeString(mixed $value): bool
    {
        return $value === null || is_scalar($value) || $value instanceof Stringable;
    }
}