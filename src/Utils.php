<?php

namespace Redot\Validator;

use Stringable;

class Utils
{
    /**
     * Check if value can be cast to string.
     *
     * @param mixed $value
     * @return bool
     */
    public static function canBeString(mixed $value): bool
    {
        return $value === null || is_scalar($value) || $value instanceof Stringable;
    }

    /**
     * Get item from array using dot notation.
     *
     * @param array<string, mixed> $array
     * @param string $key
     * @param mixed $default
     * @return mixed
     */
    public static function getValueFromDottedAssoc(array $array, string $key, mixed $default = null): mixed
    {
        if (array_key_exists($key, $array)) {
            return $array[$key];
        }

        foreach (explode('.', $key) as $segment) {
            if (!is_array($array) || !array_key_exists($segment, $array)) {
                return $default;
            }

            $array = $array[$segment];
        }

        return $array;
    }
}
