<?php

namespace Redot\Validator\Rules;

use Redot\Validator\AbstractRule;

class EmailRule extends AbstractRule
{
    /**
     * {@inheritdoc}
     */
    protected string $message = 'Value is not a valid email address.';

    /**
     * Rule name.
     *
     * @return string
     */
    public function getName(): string
    {
        return 'email';
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
        return filter_var($value, FILTER_VALIDATE_EMAIL) !== false;
    }
}
