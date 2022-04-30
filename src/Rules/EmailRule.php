<?php

namespace Validator\Rules;

use Validator\AbstractRule;

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
     * @param mixed $params
     */
    public function validate($value, ...$params): bool
    {
        return filter_var($value, FILTER_VALIDATE_EMAIL) !== false;
    }
}