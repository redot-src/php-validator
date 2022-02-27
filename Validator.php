<?php

namespace Validator;

use BadMethodCallException;
use JetBrains\PhpStorm\Pure;
use ReflectionClass;

class Validator
{

    /**
     * Array holding registered rules
     *
     * @var array
     */
    public static array $rules = [];


    /**
     * Array holding validation failures
     *
     * @var array
     */
    protected array $errors = [];


    /**
     * Variable contains field value
     *
     * @var mixed
     */
    protected mixed $value;


    /**
     * Validator constructor
     *
     * @param mixed $value
     */
    public function __construct(mixed $value)
    {
        $this->value = $value;
        return $this;
    }


    /**
     * Initiate new validator
     *
     * @param mixed $value
     * @return Validator
     */
    #[Pure]
    public static function init(mixed $value): static
    {
        return new static($value);
    }


    /**
     * Validate Multiple Entries, $entries should be an assoc array
     * formatted as [string $key => [mixed $value, string $rules]]
     *
     * @param array $values
     * @param array $entries
     * @return array|bool
     */
    public static function initMultiple(array $values, array $entries): array|bool
    {
        $errors = [];

        foreach ($entries as $key => $entry) {
            $validator = Validator::init($values[$key]);
            $rules = explode('|', $entry);

            foreach ($rules as $rule) {
                if (strpos($rule, ':')) $rule = explode(':', $rule);
                else $rule = [$rule];

                // Chain validations
                if (method_exists($validator, $rule[0])) $validator->{$rule[0]}(...array_slice($rule, 1));
                else $validator->rule($rule[0], ...array_slice($rule, 1));
            }

            if (!$validator->validate()) $errors[$key] = $validator->errors();
        }

        return $errors ?: true;
    }


    /**
     * Register custom rule
     *
     * @param string $rule
     * @return void
     */
    public static function register(string $rule): void
    {
        $rule = new $rule;
        $rule->name = $rule->name ?: self::getRuleName($rule);
        self::$rules[$rule->name] = $rule;
    }


    /**
     * Required rule
     *
     * @return $this
     */
    public function required(): static
    {
        if (empty($this->value)) $this->error('required');
        return $this;
    }


    /**
     * Email rule
     *
     * @return $this
     */
    public function email(): static
    {
        if (!filter_var($this->value, FILTER_VALIDATE_EMAIL)) $this->error('email');
        return $this;
    }


    /**
     * Regex pattern rule
     *
     * @param string $pattern
     * @return $this
     */
    public function pattern(string $pattern): static
    {
        if (!preg_match($pattern, $this->value)) $this->error('pattern');
        return $this;
    }


    /**
     * Minimum rule
     *
     * @param $min
     * @return $this
     */
    public function min($min): static
    {
        if (
            (is_string($this->value) && strlen($this->value) < $min) ||
            ((is_numeric($this->value) || strtotime($this->value)) && $this->value < $min)
        ) $this->error('min');
        return $this;
    }


    /**
     * Maximum rule
     *
     * @param $max
     * @return $this
     */
    public function max($max): static
    {
        if (
            (is_string($this->value) && strlen($this->value) > $max) ||
            ((is_numeric($this->value) || strtotime($this->value)) && $this->value > $max)
        ) $this->error('max');
        return $this;
    }


    /**
     * Equal rule
     *
     * @param mixed $value
     * @return $this
     */
    public function equal(mixed $value): static
    {
        if ($this->value !== $value) $this->error($value);
        return $this;
    }


    /**
     * Check if the file extension is not same the parameter
     *
     * @param string $ext
     * @return $this
     */
    public function ext(string $ext): static
    {
        if (strtolower(pathinfo($this->value, PATHINFO_EXTENSION)) !== strtolower($ext)) $this->error('ext');
        return $this;
    }


    /**
     * Check if $value is a valid date
     *
     * @return $this
     */
    public function date(): static
    {
        if (strtotime($this->value) === false) $this->error('date');
        return $this;
    }


    /**
     * Check if $value is matching alpha pattern
     *
     * @return $this
     */
    public function alpha(): static
    {
        if (!preg_match("/^([\p{L}]+)$/u", $this->value)) $this->error('alpha');
        return $this;
    }


    /**
     * Check if $value between $start and $end
     *
     * @param float $start
     * @param float $end
     * @return $this
     */
    public function between(float $start, float $end): static
    {
        if ($this->value >= $start && $this->value <= $end) $this->error('in');
        return $this;
    }


    /**
     * Check if $value contains specific $needle
     *
     * @param mixed $needle
     * @return $this
     */
    public function contains(mixed $needle): static
    {
        if (
            (is_array($this->value) && !in_array($needle, $this->value)) ||
            (is_string($this->value) && !str_contains($this->value, $needle))
        ) $this->error('contains');
        return $this;
    }


    /**
     * Check if $value doesn't contain specific $needle
     *
     * @param mixed $needle
     * @return $this
     */
    public function doesntContain(mixed $needle): static
    {
        if (
            (is_array($this->value) && in_array($needle, $this->value)) ||
            (is_string($this->value) && str_contains($this->value, $needle))
        ) $this->error('doesntContain');
        return $this;
    }


    /**
     * String rule
     *
     * @return $this
     */
    public function string(): static
    {
        if (gettype($this->value) !== 'string') $this->error('string');
        return $this;
    }


    /**
     * Integer rule
     *
     * @return $this
     */
    public function integer(): static
    {
        if (gettype($this->value) !== 'integer') $this->error('integer');
        return $this;
    }


    /**
     * Double rule
     *
     * @return $this
     */
    public function double(): static
    {
        if (gettype($this->value) !== 'double') $this->error('double');
        return $this;
    }


    /**
     * Array rule
     *
     * @return $this
     */
    public function array(): static
    {
        if (gettype($this->value) !== 'array') $this->error('array');
        return $this;
    }


    /**
     * Object rule
     *
     * @return $this
     */
    public function object(): static
    {
        if (gettype($this->value) !== 'object') $this->error('object');
        return $this;
    }


    /**
     * Apply custom rule
     *
     * @param string $name
     * @param mixed $params
     * @return $this
     */
    public function rule(string $name, mixed ...$params): static
    {
        $rule = self::$rules[$name];

        // Handle undeclared rule
        if (!$rule) throw new BadMethodCallException("Cannot find validation rule: $rule");

        if (!$rule->check($this->value, ...$params)) $this->error($name);
        return $this;
    }


    /**
     * Get rule name
     *
     * @param Rule $rule
     * @return string
     */
    private static function getRuleName(Rule $rule): string
    {
        return (new ReflectionClass($rule))->getShortName();
    }


    /**
     * Add validation failure
     *
     * @param string $rule
     * @return void
     */
    protected function error(string $rule): void
    {
        $this->errors[$rule] = false;
    }


    /**
     * Get validation failures
     *
     * @return array
     */
    public function errors(): array
    {
        return array_keys($this->errors);
    }


    /**
     * Get validation result
     *
     * @return bool
     */
    public function validate(): bool
    {
        return count($this->errors) === 0;
    }


    /**
     * Get errors in JSON format
     *
     * @return string
     */
    public function __toString(): string
    {
        return json_encode($this->errors());
    }
}
