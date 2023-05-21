<?php

use Redot\Validator\Validator;

test('Date: valid case', function () {
    expect(Validator::date('2020-01-01'))->toBe(true);
});

test('Date: invalid case', function () {
    expect(Validator::date('test'))->toBe(false);
});
