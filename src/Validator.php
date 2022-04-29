<?php

namespace Validator;

use Validator\Contracts\Rule;
use Validator\Contracts\Validator as ValidatorContract;
use Validator\Errors\{
    DuplicateRuleException,
    RuleNotFoundException,
    InvalidRuleException,
};

class Validator implements ValidatorContract
{
    /**
     * Registered validation rules.
     *
     * @var array
     */
    public static array $rules = [];

    /**
     * Validation failures.
     *
     * @var array
     */
    protected array $errors = [];

    /**
     * Validation current value.
     *
     * @var mixed
     */
    protected mixed $value;

    /**
     * Validator constructor.
     *
     * @param mixed $value
     */
    public function __construct(mixed $value = null)
    {
        $this->value = $value;
    }

    /**
     * Initiate new validator.
     *
     * @param mixed $value
     * @return Validator
     */
    public static function init(mixed $value = null): Validator
    {
        return new static($value);
    }

    /**
     * Validate Multiple Entries.
     *
     * @param array $values
     * @param array $entries
     * @return array|bool
     */
    public static function initMultiple(array $values, array $entries): array|bool
    {
        $errors = [];
        $validator = new static();

        foreach ($entries as $key => $entry) {
            $validator->setValue($values[$key]);
            $rules = explode('|', $entry);

            foreach ($rules as $rule) {
                $rule = explode(':', $rule);
                $validator->{$rule[0]}(...explode(',', $rule[1] ?? ''));
            }

            if (!$validator->validate()) {
                $errors[$key] = $validator->getErrors();
                $validator->clearErrors();
            }
        }

        return $errors ?: true;
    }

    /**
     * Set validation value.
     *
     * @param mixed $value
     * @return void
     */
    public function setValue(mixed $value): void
    {
        $this->value = $value;
    }

    /**
     * Register a rule to validator.
     *
     * @param string $rule
     * @return void
     */
    public static function registerRule(string $rule): void
    {
        $obj = new $rule;

        if (!$obj instanceof Rule) {
            throw new InvalidRuleException("Rule [$rule] must be an instance of Rule.");
        }

        $name = $obj->getName();
        if (isset(static::$rules[$name])) {
            throw new DuplicateRuleException("Rule [$rule] already registered.");
        }

        static::$rules[$name] = $obj;
    }

    /**
     * Check if rule exists.
     *
     * @param string $rule
     * @return bool
     */
    public static function hasRule(string $name): bool
    {
        return isset(static::$rules[$name]);
    }

    /**
     * Get validation result.
     *
     * @return bool
     */
    public function validate(): bool
    {
        return empty($this->errors);
    }

    /**
     * Add validation error.
     *
     * @param Rule $rule
     * @param mixed $params
     */
    protected function addError(Rule $rule, mixed ...$params): void
    {
        $name = $rule->getName();
        $message = preg_replace_callback('/\{(\d+)\}/', function ($matches) use ($params) {
            return $params[$matches[1]];
        }, $rule->getMessage());

        $this->errors[$name] = $message;
    }

    /**
     * Get validation errors.
     *
     * @return array
     */
    public function getErrors(): array
    {
        return $this->errors;
    }

    /**
     * Clear validation errors.
     *
     * @return void
     */
    public function clearErrors(): void
    {
        $this->errors = [];
    }

    /**
     * Get errors in JSON format
     *
     * @return string
     */
    public function __toString(): string
    {
        return json_encode($this->getErrors(), JSON_UNESCAPED_UNICODE);
    }

    /**
     * Call validation rule.
     *
     * @param string $name
     * @param mixed ...$arguments
     * @return Validator
     */
    public function __call(string $name, array $arguments = [])
    {
        $rule = static::$rules[$name] ?? null;

        if (!$rule) {
            throw new RuleNotFoundException("Rule [$name] does not exist.");
        }

        if (!$rule->validate($this->value, ...$arguments)) {
            $this->addError($rule, ...$arguments);
        }

        return $this;
    }
}