<?php

namespace Validator\Rules;

use InvalidArgumentException;
use Traversable;
use Validator\AbstractRule;

class EachRule extends AbstractRule
{
    /**
     * {@inheritdoc}
     */
    protected string $message = 'Not all values match the rule.';

    /**
     * Rule name.
     *
     * @return string
     */
    public function getName(): string
    {
        return 'each';
    }

    /**
     * Check if rule is valid.
     *
     * @param mixed $value
     * @param mixed ...$params
     * @return bool
     *
     * @throws InvalidArgumentException
     */
    public function validate(mixed $value, ...$params): bool
    {
        if (!is_array($value) && !$value instanceof Traversable) {
            throw new InvalidArgumentException('Value must be an array or Traversable.');
        }

        if (!count($params)) {
            throw new InvalidArgumentException('Each rule requires at least one parameter.');
        }

        $callback = array_shift($params);

        if (!is_callable($callback)) {
            throw new InvalidArgumentException('Callback must be callable.');
        }

        foreach ($value as $item) {
            if (!call_user_func($callback, $item)) {
                return false;
            }
        }

        return true;
    }
}