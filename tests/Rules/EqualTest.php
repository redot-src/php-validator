<?php

use Validator\Validator;

test('Equal: valid case', function () {
    expect(Validator::init('test')->equal('test')->validate())->toBe(true);
});

test('Equal: invalid case', function () {
    expect(Validator::init('test')->equal('test2')->validate())->toBe(false);
});