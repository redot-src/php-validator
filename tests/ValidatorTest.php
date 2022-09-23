<?php

use Redot\Validator\Validator;
use Redot\Validator\AbstractRule;
use Redot\Validator\Errors\InvalidRuleException;
use Redot\Validator\Errors\RuleNotFoundException;
use Redot\Validator\Errors\DuplicateRuleException;

class ValidatorTest extends AbstractRule
{
    protected string $message = 'Value should be equal to 1.';

    public function getName(): string
    {
        return 'equalsOne';
    }

    public function validate(mixed $value, mixed ...$params): bool
    {
        return $value === 1;
    }
}

it('can register a rule', function () {
    Validator::addRule(ValidatorTest::class);
    expect(Validator::hasRule(ValidatorTest::class))->toBe(true);
});

it('can validate a rule', function () {
    expect(Validator::init(1)->equalsOne()->validate())->toBe(true);
    expect(Validator::init(2)->equalsOne()->validate())->toBe(false);
});

it('throws an exception if rule is not an instance of Rule', function () {
    expect(fn () => Validator::addRule(stdClass::class))
        ->toThrow(InvalidRuleException::class);
});

it('throws an exception if rule is already registered', function () {
    expect(fn () => Validator::addRule(ValidatorTest::class))
        ->toThrow(DuplicateRuleException::class);
});

it('throw an exception if rule is not registered', function () {
    expect(fn () => Validator::init(1)->notExists()->validate())
        ->toThrow(RuleNotFoundException::class);
});

it('can validate multiple values', function () {
    $entries = ['email' => 'test@vendor.com'];
    $validations = ['email' => 'required|email|min:5|max:255'];
    expect(Validator::initMultiple($entries, $validations))->toBe(true);
});

it('can validate multiple entries', function () {
    expect(Validator::initMultiple(['one' => 1], ['one' => 'equalsOne']))
        ->toBe(true);
});

it('can change the default error message', function () {
    Validator::setMessages([ValidatorTest::class => 'test']);
    expect(Validator::init(2)->equalsOne()->getErrors())
        ->toBe(['equalsOne' => 'test']);

    Validator::setMessages(['equalsOne' => 'test2']);
    expect(Validator::init(2)->equalsOne()->getErrors())
        ->toBe(['equalsOne' => 'test2']);
});

it('can validate a rule statically', function () {
    expect(Validator::equalsOne(1))->toBe(true);
    expect(Validator::equalsOne(2))->toBe(false);
});