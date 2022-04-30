<?php

use Validator\Validator;

test('Alpha: valid case', function () {
    expect(Validator::init('test')->alpha()->validate())->toBe(true);
});

test('Alpha: invalid case', function () {
    expect(Validator::init('test2')->alpha()->validate())->toBe(false);
});