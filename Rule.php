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
     */
    abstract public function check(mixed $value): bool;
}