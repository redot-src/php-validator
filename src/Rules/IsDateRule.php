<?php

namespace Validator\Rules;

use Validator\AbstractRule;

class IsDateRule extends AbstractRule
{
    /**
     * {@inheritdoc}
     */
    protected string $message = 'Value should be a valid date.';

    /**
     * Rule name.
     * 
     * @return string
     */
    public function getName(): string
    {
        return 'isDate';
    }

    /**
     * Check if rule is valid.
     *
     * @param string $value
     * @param mixed ...$params
     * @return bool
     */
    public function validate(mixed $value, ...$params): bool
    {
        return strtotime($value) !== false;
    }
}