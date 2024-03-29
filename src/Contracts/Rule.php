<?php

namespace Redot\Validator\Contracts;

interface Rule
{
    /**
     * Rule name.
     *
     * @return string
     */
    public function getName(): string;

    /**
     * Rule failure message.
     *
     * @return string
     */
    public function getMessage(): string;

    /**
     * Validate rule.
     *
     * @param mixed $value
     * @param mixed ...$params
     * @return bool
     */
    public function validate(mixed $value, mixed ...$params): bool;
}
