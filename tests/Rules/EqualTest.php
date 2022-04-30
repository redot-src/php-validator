<?php

use Validator\Validator;
use Validator\Rules\EqualRule;

Validator::registerRule(EqualRule::class);

test('Equal: valid case', function () {
    expect(Validator::init('test')->equal('test')->validate())->toBe(true);
});

test('Equal: invalid case', function () {
    expect(Validator::init('test')->equal('test2')->validate())->toBe(false);
});