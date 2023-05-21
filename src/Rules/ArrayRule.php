<?php

namespace Redot\Validator\Rules;

use Redot\Validator\AbstractRule;

class ArrayRule extends AbstractRule
{
    /**
     * {@inheritdoc}
     */
    protected string $message = 'Value is not a valid array.';

    /**
     * Rule name.
     *
     * @return string
     */
    public function getName(): string
    {
        return 'array';
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
        return is_array($value);
    }
}
