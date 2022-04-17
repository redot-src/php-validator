<?php

use Validator\Rule;
use Validator\Validator;

class CustomRule extends Rule
{
    public string $name = 'custom';

    public function check(mixed $value, mixed ...$params): bool
    {
        return false;
    }
}

test('Test custom rule registration', function () {
    Validator::register(CustomRule::class);
    expect(Validator::$rules)->toBeTruthy();
});

test('Test custom rule call', function () {
    expect(Validator::init(null)->custom()->validate())->toBe(false);
    expect(Validator::init(null)->rule('custom')->validate())->toBe(false);
});
