<?php

use Redot\Validator\Validator;

test('IsDate: valid case', function () {
    expect(Validator::init('2020-01-01')->isDate()->validate())->toBe(true);
});

test('IsDate: invalid case', function () {
    expect(Validator::init('test')->isDate()->validate())->toBe(false);
});