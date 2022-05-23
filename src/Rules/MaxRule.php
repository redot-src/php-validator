<?php

namespace Redot\Validator\Rules;

use ArgumentCountError;
use Redot\Validator\AbstractRule;

class MaxRule extends AbstractRule
{
    /**
     * {@inheritdoc}
     */
    protected string $message = 'Value does not meet the maximum length of {0}.';

    /**
     * Rule name.
     * 
     * @return string
     */
    public function getName(): string
    {
        return 'max';
    }

    /**
     * Check if rule is valid.
     *
     * @param mixed $value
     * @param mixed ...$params
     * @return bool
     *
     * @throws ArgumentCountError
     */
    public function validate(mixed $value, ...$params): bool
    {
        if (count($params) < 1) {
            throw new ArgumentCountError('Max rule requires at least one parameter.');
        }

        if (is_string($value)) {
            return strlen($value) <= $params[0];
        }

        if (is_array($value)) {
            return count($value) <= $params[0];
        }

        return $value <= $params[0];
    }
}