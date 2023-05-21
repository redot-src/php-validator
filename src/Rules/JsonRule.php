<?php

namespace Redot\Validator\Rules;

use Redot\Validator\AbstractRule;

class JsonRule extends AbstractRule
{
    /**
     * {@inheritdoc}
     */
    protected string $message = 'The attribute must be a valid JSON string.';

    /**
     * Rule name.
     *
     * @return string
     */
    public function getName(): string
    {
        return 'json';
    }

    /**
     * Check if rule is valid.
     *
     * @param mixed $value
     * @param mixed ...$params
     * @return bool
     */
    public function validate(mixed $value, ...$params): bool
    {
        return is_string($value) && is_array(json_decode($value, true)) && (json_last_error() == JSON_ERROR_NONE);
    }
}
