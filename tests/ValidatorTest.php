<?php

use Redot\Validator\Validator;
use Redot\Validator\AbstractRule;
use Redot\Validator\Errors\InvalidRuleException;
use Redot\Validator\Errors\RuleNotFoundException;
use Redot\Validator\Errors\DuplicateRuleException;
use Redot\Validator\Rules\MinRule;

class EqualsOne extends AbstractRule
{
    /**
     * @inheritDoc
     */
    protected string $message = 'Value should be equal to 1.';

    /**
     * @inheritDoc
     */
    public function getName(): string
    {
        return 'equalsOne';
    }

    /**
     * @inheritDoc
     */
    public function validate(mixed $value, mixed ...$params): bool
    {
        return $value === 1;
    }
}

it('can register a rule', function () {
    Validator::addRule(EqualsOne::class);
    expect(Validator::hasRule(EqualsOne::class))->toBe(true);
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
    expect(fn () => Validator::addRule(EqualsOne::class))
        ->toThrow(DuplicateRuleException::class);
});

it('throw an exception if rule is not registered', function () {
    expect(fn () => Validator::init(1)->notExists()->validate())
        ->toThrow(RuleNotFoundException::class);
});

it('can validate multiple rules (flat)', function () {
    $entries = ['email' => 'test@vendor.com'];
    $validations = ['email' => 'required|email|min:5|max:255'];

    expect(Validator::initMultiple($entries, $validations))->toBe(true);
});

it('can validate a nested rules (object)', function () {
    $entries = [
        'user' => [
            'name' => 'John Doe',
            'email' => 'email@vendor.com',
        ],
    ];

    $validations = [
        'user.name' => 'required|min:5|max:255',
        'user.email' => 'required|email|min:5|max:255',
    ];

    expect(Validator::initMultiple($entries, $validations))->toBe(true);
});

it('can validate a nested rules (array)', function () {
    $entries = [
        'products' => [
            ['name' => 'Product 1', 'price' => 100],
            ['name' => 'Product 2', 'price' => 200],
        ],
    ];

    $validations = [
        'products.*.name' => 'required|min:5|max:255',
        'products.*.price' => 'required|min:1',
    ];

    expect(Validator::initMultiple($entries, $validations))->toBe(true);
});

it('can validate a mixed nested rules', function () {
    $entries = [
        'products' => [
            [
                'name' => [
                    'locales' => [
                        'en' => 'iPhone 11 Pro',
                        'ar' => 'آيفون 11 برو'
                    ],
                    'default' => 'iPhone 11 Pro'
                ],
                'price' => 100,
            ],
            [
                'name' => [
                    'locales' => [
                        'en' => 'Samsung Galaxy S10',
                        'ar' => 'سامسونج جالاكسي S10'
                    ],
                    'default' => 'Samsung Galaxy S10'
                ],
                'price' => 200,
            ],
        ],
    ];

    $rules = [
        'products.*.name.locales.*' => 'required|string',
        'products.*.name.default' => 'required|string',
        'products.*.price' => 'required|numeric',
    ];

    expect(Validator::initMultiple($entries, $rules))->toBe(true);
});

it('can change the default error message', function () {
    Validator::setMessages([EqualsOne::class => 'test']);
    expect(Validator::init(2)->equalsOne()->getErrors())
        ->toBe(['equalsOne' => 'test']);

    Validator::setMessages(['equalsOne' => 'test2']);
    expect(Validator::init(2)->equalsOne()->getErrors())
        ->toBe(['equalsOne' => 'test2']);
});

it('can read parameters to error message', function () {
    $minimum = 5;
    $message = (new MinRule())->getMessage();

    expect(Validator::init('test')->min($minimum)->getErrors())
        ->toBe(['min' => str_replace('{0}', $minimum, $message)]);
});

it('can validate a rule statically', function () {
    expect(Validator::equalsOne(1))->toBe(true);
    expect(Validator::equalsOne(2))->toBe(false);
});
