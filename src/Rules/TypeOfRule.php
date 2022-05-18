<?php

namespace Validator\Rules;

use InvalidArgumentException;
use Validator\AbstractRule;

class TypeOfRule extends AbstractRule
{
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
     * Get allowed types.
     *
     * @return string[]
     */
    protected function getTypes(): array
    {
        return [
            self::TYPE_INTEGER,
            self::TYPE_DOUBLE,
            self::TYPE_STRING,
            self::TYPE_BOOLEAN,
            self::TYPE_ARRAY,
            self::TYPE_OBJECT,
            self::TYPE_RESOURCE,
            self::TYPE_NULL,
        ];
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

        if (!is_string($type)) {
            throw new InvalidArgumentException('Type must be a string.');
        }

        if (!in_array($type, $this->getTypes())) {
            throw new InvalidArgumentException(sprintf(
                'Type %s is not supported. Supported types are: %s',
                $type,
                implode(', ', $this->getTypes())
            ));
        }

        $this->message = str_replace('{type}', $type, $this->message);
        return strtolower(gettype($value)) === $type;
    }
}