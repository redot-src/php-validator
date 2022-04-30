<?php

namespace Validator;

use Stringable;

class Utils
{
    public static function canBeString(mixed $value): bool
    {
        return $value === null || is_scalar($value) || $value instanceof Stringable;
    }
}