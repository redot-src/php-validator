<?php

namespace Redot\Validator\Rules;

use Redot\Validator\AbstractRule;

class DateRule extends AbstractRule
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
        return 'date';
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
