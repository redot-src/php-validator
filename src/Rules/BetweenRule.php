<?php

namespace Validator\Rules;

use Validator\AbstractRule;

class BetweenRule extends AbstractRule
{
    /**
     * {@inheritdoc}
     */
    protected string $message = 'Value is not between {0} and {1}.';

    /**
     * Rule name.
     * 
     * @return string
     */
    public function getName(): string
    {
        return 'between';
    }

    /**
     * Check if rule is valid.
     * 
     * @param mixed $value
     * @param mixed $params
     */
    public function validate($value, ...$params): bool
    {
        return $value >= $params[0] && $value <= $params[1];
    }
}