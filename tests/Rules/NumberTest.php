<?php

use Redot\Validator\Validator;

test('Number: valid case', function () {
    expect(Validator::number(123))->toBe(true);
});

test('Number: invalid case', function () {
    expect(Validator::number('test'))->toBe(false);
});
