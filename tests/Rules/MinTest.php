<?php

use Validator\Validator;
use Validator\Rules\MinRule;

Validator::registerRule(MinRule::class);

test('Min: valid case', function () {
    expect(Validator::init(6)->min(5)->validate())->toBe(true);
});

test('Min: invalid case', function () {
    expect(Validator::init(5)->min(6)->validate())->toBe(false);
});