<?php

namespace Validator\Contracts;

interface Validator
{
    /**
     * Initiate new validator.
     *
     * @param mixed $value
     * @return \Validator\Validator
     */
    public static function init(mixed $value): \Validator\Validator;

    /**
     * Validate Multiple Entries.
     *
     * @param array $values
     * @param array $entries
     * @return array|bool
     */
    public static function initMultiple(array $values, array $entries): array|bool;

    /**
     * Set validation value.
     *
     * @param mixed $value
     * @return void
     */
    public function setValue(mixed $value): void;

    /**
     * Add a rule to validator.
     *
     * @param string $rule
     * @return void
     */
    public static function addRule(string $rule): void;

    /**
     * Check if rule exists.
     *
     * @param string $rule
     * @return bool
     */
    public static function hasRule(string $rule): bool;

    /**
     * Get validation result.
     *
     * @return bool
     */
    public function validate(): bool;

    /**
     * Get validation errors.
     *
     * @return array
     */
    public function getErrors(): array;

    /**
     * Clear validation errors.
     *
     * @return void
     */
    public function clearErrors(): void;

    /**
     * Change default error messages.
     *
     * @param array $messages
     * @return void
     */
    public static function setMessages(array $messages): void;
}