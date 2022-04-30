<?php

use Validator\Validator;
use Validator\Rules\IsDateRule;

Validator::registerRule(IsDateRule::class);

test('IsDate: valid case', function () {
    expect(Validator::init('2020-01-01')->isDate()->validate())->toBe(true);
});

test('IsDate: invalid case', function () {
    expect(Validator::init('test')->isDate()->validate())->toBe(false);
});