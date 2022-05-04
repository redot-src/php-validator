<?php

namespace Validator;

use Validator\Contracts\Validator as ValidatorContract;
use Validator\Errors\{DuplicateRuleException, InvalidRuleException, RuleNotFoundException,};

/**
 * @method static Validator alpha()
 * @method static Validator between(int $start, int $end)
 * @method static Validator contains(mixed ...$value)
 * @method static Validator doesntContain(mixed ...$value)
 * @method static Validator each(callable $callback)
 * @method static Validator email()
 * @method static Validator equal(mixed $value)
 * @method static Validator isDate()
 * @method static Validator max(int $max)
 * @method static Validator min(int $min)
 * @method static Validator pattern(string $pattern)
 * @method static Validator required()
 */
class Validator implements ValidatorContract
{
    /**
     * Registered validation rules.
     *
     * @var array
     */
    protected static array $rules = [];

    /**
     * Rules aliases.
     *
     * @var array
     */
    protected static array $aliases = [];

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
     * Add a rule to validator.
     *
     * @param string $rule
     * @param bool $override
     * @return void
     *
     * @throws DuplicateRuleException
     * @throws InvalidRuleException
     */
    public static function addRule(string $rule, bool $override = false): void
    {
        $obj = new $rule;

        if (!$obj instanceof AbstractRule) {
            throw new InvalidRuleException("Rule [$rule] must be an instance of AbstractRule.");
        }

        if (static::hasRule($rule) && !$override) {
            throw new DuplicateRuleException("Rule [$rule] already registered.");
        }

        static::$rules[$rule] = $obj;
        static::$aliases[$obj->getName()] = $rule;
    }

    /**
     * Check if rule exists.
     *
     * @param string $rule
     * @return bool
     */
    public static function hasRule(string $rule): bool
    {
        return isset(static::$rules[$rule]) || isset(static::$aliases[$rule]);
    }

    /**
     * Get rule alias.
     *
     * @param string $rule
     * @return string
     */
    protected static function getAlias(string $rule): string
    {
        return static::$aliases[$rule] ?? $rule;
    }

    /**
     * Get rule instance.
     *
     * @param string $rule
     * @return AbstractRule
     *
     * @throws RuleNotFoundException
     */
    protected static function getRule(string $rule): AbstractRule
    {
        if (!static::hasRule($rule)) {
            throw new RuleNotFoundException("Rule [$rule] not found.");
        }

        return static::$rules[static::getAlias($rule)];
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
     * @param AbstractRule $rule
     * @param mixed ...$params
     */
    protected function addError(AbstractRule $rule, mixed ...$params): void
    {
        $name = $rule->getName();
        $message = $this->resolveErrorMessage($rule->getMessage(), ...$params);
        $this->errors[$name] = $message;
    }

    /**
     * Resolve rule error message.
     *
     * @param string $message
     * @param mixed ...$params
     * @return string
     */
    protected function resolveErrorMessage(string $message, mixed ...$params): string
    {
        return preg_replace_callback('/\{(\d+)}/', function ($matches) use ($params) {
            $value = $params[$matches[1]];
            if (Utils::canBeString($value)) return $value;
            return json_encode($value, JSON_UNESCAPED_UNICODE);
        }, $message);
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
     * Change default error messages.
     *
     * @param array $messages
     * @return void
     */
    public static function setMessages(array $messages): void
    {
        foreach ($messages as $rule => $message) {
            static::getRule($rule)->setMessage($message);
        }
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
        $rule = static::getRule($name);

        if (!$rule->validate($this->value, ...$arguments)) {
            $this->addError($rule, ...$arguments);
        }

        return $this;
    }
}