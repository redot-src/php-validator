<?php

use Redot\Validator\Validator;

test('Alpha: valid case', function () {
    expect(Validator::alpha('test'))->toBe(true);
});

test('Alpha: invalid case', function () {
    expect(Validator::alpha('test2'))->toBe(false);
});
