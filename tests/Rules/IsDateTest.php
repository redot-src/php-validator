<?php

use Redot\Validator\Validator;

test('IsDate: valid case', function () {
    expect(Validator::isDate('2020-01-01'))->toBe(true);
});

test('IsDate: invalid case', function () {
    expect(Validator::isDate('test'))->toBe(false);
});
