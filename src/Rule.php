<?php

namespace Validator;

abstract class Rule
{
    /**
     * Rule name
     * 
     * @var string
     */
    public string $name = '';

    /**
     * Rule checking function
     * 
     * @param mixed $value
     * @param mixed $params
     */
    abstract public function check(mixed $value, mixed ...$params): bool;
}