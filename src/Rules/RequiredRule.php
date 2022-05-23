<?php

namespace Redot\Validator\Rules;

use Redot\Validator\AbstractRule;

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
     * @param mixed ...$params
     * @return bool
     */
    public function validate(mixed $value, ...$params): bool
    {
        return !empty($value);
    }
}