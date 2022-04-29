<?php

use Validator\Validator;
use Validator\Rules\Required;

Validator::registerRule(Required::class);

test('Required: valid case', function () {
    expect(Validator::init('foo')->required()->validate())->toBe(true);
});

test('Required: invalid case', function () {
    expect(Validator::init('')->required()->validate())->toBe(false);
});