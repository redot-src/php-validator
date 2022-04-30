<?php

namespace Validator\Rules;

use ArgumentCountError;
use Validator\AbstractRule;

class MinRule extends AbstractRule
{
    /**
     * {@inheritdoc}
     */
    protected string $message = 'Value doesn\'t meet the minimum length of {0}.';

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
     * @param mixed $params
     *
     * @throws ArgumentCountError
     */
    public function validate($value, ...$params): bool
    {
        if (count($params) < 1) {
            throw new ArgumentCountError('Min rule requires at least one parameter.');
        }

        if (is_string($value)) {
            return strlen($value) >= $params[0];
        }

        if (is_array($value)) {
            return count($value) >= $params[0];
        }

        return $value >= $params[0];
    }
}