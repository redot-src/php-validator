<?php

use Redot\Validator\Validator;

test('JSON: valid case', function () {
    expect(Validator::json('{"foo":"bar"}'))->toBe(true);
});

test('JSON: invalid case', function () {
    expect(Validator::json('test'))->toBe(false);
});
