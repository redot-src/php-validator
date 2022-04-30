<?php

use Validator\Validator;
use Validator\Contracts\Rule;
use Validator\Errors\InvalidRuleException;
use Validator\Errors\DuplicateRuleException;

class EqualsOne implements Rule
{
    public function getName(): string
    {
        return 'equalsOne';
    }

    public function getMessage(): string
    {
        return 'The value must be equal to one.';
    }

    public function validate(mixed $value, mixed ...$params): bool
    {
        return $value === 1;
    }
}

it('can register a rule', function () {
    Validator::registerRule(EqualsOne::class);
    expect(Validator::hasRule(EqualsOne::class))->toBe(true);
});

it('can validate a rule', function () {
    expect(Validator::init(1)->equalsOne()->validate())->toBe(true);
    expect(Validator::init(2)->equalsOne()->validate())->toBe(false);
});

it('can validate multiple entries', function () {
    expect(Validator::initMultiple(['one' => 1], ['one' => 'equalsOne']))
        ->toBe(true);
});

it('throw an exception if rule is not an instance of Rule', function () {
    expect(fn () => Validator::registerRule(stdClass::class))
        ->toThrow(InvalidRuleException::class);
});

it('throws an exception if rule is already registered', function () {
    expect(fn () => Validator::registerRule(EqualsOne::class))
        ->toThrow(DuplicateRuleException::class);
});

it('can validate multiple values', function () {
    $entries = ['email' => 'test@vendor.com'];
    $validations = ['email' => 'required|email|min:5|max:255'];
    expect(Validator::initMultiple($entries, $validations))->toBe(true);
});