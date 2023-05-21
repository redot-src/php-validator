<?php

namespace Redot\Validator\Rules;

use ArgumentCountError;
use Redot\Validator\AbstractRule;

class DoesntContainRule extends AbstractRule
{
    /**
     * {@inheritdoc}
     */
    protected string $message = 'Value contains {0}.';

    /**
     * Rule name.
     *
     * @return string
     */
    public function getName(): string
    {
        return 'doesntContain';
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
            throw new ArgumentCountError('DoesntContain rule requires at least one parameter.');
        }

        foreach ($params as $param) {
            if (is_string($value) && str_contains($value, strval($param))) {
                return false;
            }

            if (is_array($value) && in_array($param, $value)) {
                return false;
            }

            if (is_object($value) && property_exists($value, strval($param))) {
                return false;
            }
        }

        return true;
    }
}
