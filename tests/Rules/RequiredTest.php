<?php

use Validator\Validator;
use Validator\Rules\RequiredRule;

Validator::registerRule(RequiredRule::class);

test('Required: valid case', function () {
    expect(Validator::init('foo')->required()->validate())->toBe(true);
});

test('Required: invalid case', function () {
    expect(Validator::init('')->required()->validate())->toBe(false);
});