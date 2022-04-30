<?php

namespace Validator\Rules;

use Validator\AbstractRule;

class AlphaRule extends AbstractRule
{
    /**
     * {@inheritdoc}
     */
    protected string $message = 'Value is not a valid alpha.';

    /**
     * Rule name.
     * 
     * @return string
     */
    public function getName(): string
    {
        return 'alpha';
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
        return ctype_alpha($value);
    }
}