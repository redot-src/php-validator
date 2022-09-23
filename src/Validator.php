<?php

namespace Redot\Validator;

use JetBrains\PhpStorm\Pure;
use Redot\Validator\Contracts\Validator as ValidatorContract;
use Redot\Validator\Errors\{
    InvalidRuleException,
    RuleNotFoundException,
    DuplicateRuleException,
};

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
 * @method static Validator typeOf(string $type)
 */
class Validator implements ValidatorContract
{
    /**
     * Registered validation rules.
     *
     * @var array<string, AbstractRule>
     */
    protected static array $rules = [];

    /**
     * Rules aliases.
     *
     * @var array<string, string>
     */
    protected static array $aliases = [];

    /**
     * Validation failures.
     *
     * @var array<string, string>
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
    final public function __construct(mixed $value = null)
    {
        $this->value = $value;
    }

    /**
     * Initiate new validator.
     *
     * @param mixed $value
     * @return Validator
     */
    #[Pure] public static function init(mixed $value = null): Validator
    {
        return new static($value);
    }

    /**
     * Validate Multiple Entries.
     *
     * @param array<string, mixed> $values
     * @param array<string, string> $entries
     * @return array<string, array<string, string>>|true
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
     * Load default rules.
     *
     * @return void
     */
    public static function loadDefaultRules(): void
    {
        $rules = glob(__DIR__ . '/Rules/*.php') ?: [];

        foreach ($rules as $rule) {
            $rule = basename($rule, '.php');
            $rule = __NAMESPACE__ . '\Rules\\' . $rule;
            Validator::addRule($rule, true);
        }
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
        return isset(static::$rules[static::getAlias($rule)]);
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
        /* @phpstan-ignore-next-line */
        return preg_replace_callback('/{(\d+)}/', function ($matches) use ($params) {
            [, $key] = $matches;
            $value = $params[$key];
            if (Utils::canBeString($value)) return $value;
            return json_encode($value, JSON_UNESCAPED_UNICODE | JSON_PRESERVE_ZERO_FRACTION);
        }, $message) ?: '';
    }

    /**
     * Get validation errors.
     *
     * @return array<string, string>
     */
    public function getErrors(): array
    {
        return $this->errors;
    }

    /**
     * Get validation error.
     *
     * @param string $key
     * @return string|null
     */
    public function getError(string $key): string|null
    {
        return $this->errors[$key] ?? null;
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
     * @param array<string, string> $messages
     * @return void
     *
     * @throws RuleNotFoundException
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
        return json_encode($this->getErrors(), JSON_UNESCAPED_UNICODE) ?: '';
    }

    /**
     * Call validation rule.
     *
     * @param string $name
     * @param array<int, mixed> $arguments
     * @return Validator
     *
     * @throws RuleNotFoundException
     */
    public function __call(string $name, array $arguments = [])
    {
        $rule = static::getRule($name);

        if (!$rule->validate($this->value, ...$arguments)) {
            $this->addError($rule, ...$arguments);
        }

        return $this;
    }

    /**
     * Call static validation rule.
     *
     * @param string $name
     * @param array<int, mixed> $arguments
     * @return bool
     *
     * @throws RuleNotFoundException
     */
    public static function __callStatic(string $name, array $arguments = []): bool
    {
        $rule = static::getRule($name);
        return $rule->validate(...$arguments);
    }
}