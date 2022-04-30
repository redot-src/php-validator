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
     * @param mixed $value
     * @param mixed $params
     */
    public function validate($value, ...$params): bool
    {
        return strtotime($value) !== false;
    }
}