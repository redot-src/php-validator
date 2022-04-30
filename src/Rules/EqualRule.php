<?php

namespace Validator\Rules;

use ArgumentCountError;
use Validator\AbstractRule;

class EqualRule extends AbstractRule
{
    /**
     * {@inheritdoc}
     */
    protected string $message = 'Value should be equal to {0}.';

    /**
     * Rule name.
     * 
     * @return string
     */
    public function getName(): string
    {
        return 'equal';
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
            throw new ArgumentCountError('Equal rule requires at least one parameter.');
        }

        return $value == $params[0];
    }
}