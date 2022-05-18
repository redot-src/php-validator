<?php

namespace Validator\Rules;

use Validator\AbstractRule;

class TypeOfRule extends AbstractRule
{
    /**
     * Allowed types
     */
    const TYPE_INTEGER = 'integer';
    const TYPE_DOUBLE = 'double';
    const TYPE_STRING = 'string';
    const TYPE_BOOLEAN = 'boolean';
    const TYPE_ARRAY = 'array';
    const TYPE_OBJECT = 'object';
    const TYPE_RESOURCE = 'resource';
    const TYPE_NULL = 'null';

    /**
     * {@inheritDoc}
     */
    protected string $message = 'Value is not a valid type of {type}.';

    /**
     * Rule name.
     * 
     * @return string
     */
    public function getName(): string
    {
        return 'typeOf';
    }

    /**
     * Check if rule is valid.
     *
     * @param mixed $value
     * @param mixed ...$params
     * @return bool
     */
    public function validate($value, ...$params): bool
    {
        $type = $params[0];
        $this->message = str_replace('{type}', $type, $this->message);
        return strtolower(gettype($value)) === $type;
    }
}