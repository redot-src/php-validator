<?php

use Validator\Validator;

test('Between: valid case', function () {
    expect(Validator::init(5)->between(1, 10)->validate())->toBe(true);
});

test('Between: invalid case', function () {
    expect(Validator::init(5)->between(1, 2)->validate())->toBe(false);
});