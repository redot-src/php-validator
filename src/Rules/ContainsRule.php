<?php

namespace Redot\Validator\Rules;

use ArgumentCountError;
use Redot\Validator\AbstractRule;

class ContainsRule extends AbstractRule
{
    /**
     * {@inheritdoc}
     */
    protected string $message = 'Value does not contain {0}.';

    /**
     * Rule name.
     *
     * @return string
     */
    public function getName(): string
    {
        return 'contains';
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
            throw new ArgumentCountError('Contain rule requires at least one parameter.');
        }

        foreach ($params as $param) {
            if (is_string($value)) {
                return str_contains($value, strval($param));
            }

            if (is_array($value)) {
                return in_array($param, $value);
            }

            if (is_object($value)) {
                return property_exists($value, strval($param));
            }

            return false;
        }
    }
}