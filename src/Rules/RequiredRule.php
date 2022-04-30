<?php

namespace Validator\Rules;

use Validator\AbstractRule;

class RequiredRule extends AbstractRule
{
    /**
     * {@inheritdoc}
     */
    protected string $message = 'Value is required.';

    /**
     * Rule name.
     * 
     * @return string
     */
    public function getName(): string
    {
        return 'required';
    }

    /**
     * Check if rule is valid.
     * 
     * @param mixed $value
     * @param mixed $params
     */
    public function validate($value, ...$params): bool
    {
        return !empty($value);
    }
}