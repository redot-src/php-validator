<?php

namespace Redot\Validator\Rules;

use ArgumentCountError;
use Redot\Validator\AbstractRule;

class MinRule extends AbstractRule
{
    /**
     * {@inheritdoc}
     */
    protected string $message = 'Value does not meet the minimum length of {0}.';

    /**
     * Rule name.
     *
     * @return string
     */
    public function getName(): string
    {
        return 'min';
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
            throw new ArgumentCountError('Min rule requires at least one parameter.');
        }

        [$min] = $params;
        if (is_string($value)) {
            return strlen($value) >= $min;
        }

        if (is_array($value)) {
            return count($value) >= $min;
        }

        return $value >= $min;
    }
}
