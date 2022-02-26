<?php

namespace Validator;

use ReflectionClass;

class Validator
{

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
    public static function init(mixed $value): static
    {
        return new static($value);
    }


    /**
     * Validate Multiple Entries, $entries should be an assoc array
     * formated as [string $key => [mixed $value, string $rules]]
     * 
     * @param array $entries
     * @return array|bool
     */
    public function initMultiple(array $entries): array|bool
    {
        $errors = [];

        foreach ($entries as $key => $entry) {
            $validator = Validator::init($entry[0]);
            $rules = explode('|', $entry[1]);

            foreach ($rules as $rule) {
                if (strpos($rule, ':')) $rule = explode(':', $rule);
                else $rule = [$rule];

                // Chain validations
                if (method_exists($validator, $rule[0])) $validator->{$rule[0]}(...array_slice($rule, 1));
                elseif (class_exists($rule[0])) $validator->rule(new $rule[0], ...array_slice($rule, 1));
            }

            if (!$validator->validate()) $errors[$key] = $validator->errors();
        }

        return $errors ?: true;
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
    public function alpah(): static
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
    public function in(float $start, float $end): static
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
     * Check if $value doesn't contains specific $needle
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
    public function string()
    {
        if (gettype($this->value) !== 'string') $this->error('string');
        return $this;
    }


    /**
     * Integer rule
     * 
     * @return $this
     */
    public function integer()
    {
        if (gettype($this->value) !== 'integer') $this->error('integer');
        return $this;
    }


    /**
     * Double rule
     * 
     * @return $this
     */
    public function double()
    {
        if (gettype($this->value) !== 'double') $this->error('double');
        return $this;
    }


    /**
     * Array rule
     * 
     * @return $this
     */
    public function array()
    {
        if (gettype($this->value) !== 'array') $this->error('array');
        return $this;
    }


    /**
     * Object rule
     * 
     * @return $this
     */
    public function object()
    {
        if (gettype($this->value) !== 'object') $this->error('object');
        return $this;
    }


    /**
     * Apply custom rule
     * 
     * @param Rule $rule
     * @param mixed $params
     * @return $this
     */
    public function rule(Rule $rule, mixed ...$params): static
    {
        $ruleName = $rule->name ?: (new ReflectionClass($rule))->getShortName();
        if (!$rule->check($this->value, ...$params)) $this->error($ruleName);
        return $this;
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
        return $this->errors;
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
