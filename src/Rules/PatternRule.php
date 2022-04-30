<?php

namespace Validator\Rules;

use ArgumentCountError;
use Validator\AbstractRule;

class PatternRule extends AbstractRule
{
    /**
     * {@inheritdoc}
     */
    protected string $message = 'Value does not match the given pattern.';

    /**
     * Rule name.
     * 
     * @return string
     */
    public function getName(): string
    {
        return 'pattern';
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
            throw new ArgumentCountError('Pattern rule requires at least one parameter.');
        }

        return preg_match($params[0], $value) !== false;
    }
}