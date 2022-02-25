<?php

namespace Validator;

use TypeError;

class Validator
{

    /**
     * Array holding validation failures
     *
     * @var array
     */
    private array $errors = [];


    /**
     * Variable contains field value
     *
     * @var mixed
     */
    private mixed $value;


    /**
     * Initiate new validator
     *
     * @param mixed $value
     */
    public function __construct(mixed $value)
    {
        $this->value = $value;
        return $this;
    }


    /**
     * Set field name
     *
     * @param mixed $value
     * @return Validator
     */
    public static function init(mixed $value): static
    {
        return new static($value);
    }


    /**
     * Validate multiple values
     * 
     * @param array $values
     * @return array|bool
     * @throws TypeError
     */
    public static function validateMultiple(array $values): array|bool
    {
        $errors = [];

        foreach ($values as $key => $value) {
            if (!is_array($value)) throw new TypeError('$values should be assoc array [$key => [$value, $rules]]');

            $validator = static::init($value[0]);
            $rules = explode('|', $value[1]);

            foreach ($rules as $rule) {
                if (strpos($rule, ':')) $rule = explode(':', $rule);
                else $rule = [$rule];

                // Chain validations
                $validator->{$rule[0]}(...array_slice($rule, 1));
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
     * @param float $min
     * @return $this
     */
    public function min(float $min): static
    {
        if (
            (is_string($this->value) && strlen($this->value) < $min) ||
            ((is_int($this->value) || strtotime($this->value)) && $this->value < $min)
        ) $this->error('min');
        return $this;
    }


    /**
     * Maximum rule
     *
     * @param float $max
     * @return $this
     */
    public function max(float $max): static
    {
        if (
            (is_string($this->value) && strlen($this->value) > $max) ||
            ((is_int($this->value) || strtotime($this->value)) && $this->value > $max)
        ) $this->error('max');
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
    public function notContains(mixed $needle): static
    {
        if (
            (is_array($this->value) && in_array($needle, $this->value)) ||
            (is_string($this->value) && str_contains($this->value, $needle))
        ) $this->error('notContains');
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
     * @return $this
     */
    public function rule(Rule $rule): static
    {
        if (!$rule->check($this->value)) $this->error($rule->name ?: get_class($rule));
        return $this;
    }


    /**
     * Add validation failure
     *
     * @param string $rule
     * @return void
     */
    private function error(string $rule): void
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
}