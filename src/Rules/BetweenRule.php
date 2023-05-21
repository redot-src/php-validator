<?php

namespace Redot\Validator\Rules;

use Redot\Validator\AbstractRule;

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
     * @param mixed ...$params
     * @return bool
     */
    public function validate(mixed $value, ...$params): bool
    {
        [$min, $max] = $params;
        return $value >= $min && $value <= $max;
    }
}
