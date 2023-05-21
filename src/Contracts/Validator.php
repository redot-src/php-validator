<?php

namespace Redot\Validator\Contracts;

interface Validator
{
    /**
     * Initiate new validator.
     *
     * @param mixed $value
     * @return \Redot\Validator\Validator
     */
    public static function init(mixed $value): \Redot\Validator\Validator;

    /**
     * Validate Multiple Entries.
     *
     * @param array<string, mixed> $values
     * @param array<string, string> $entries
     * @return array<string, string>|bool
     */
    public static function initMultiple(array $values, array $entries): array|bool;

    /**
     * Load default rules.
     *
     * @return void
     */
    public static function loadDefaultRules(): void;

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
     * @return array<string, string>
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
     * @param array<string, string> $messages
     * @return void
     */
    public static function setMessages(array $messages): void;
}
