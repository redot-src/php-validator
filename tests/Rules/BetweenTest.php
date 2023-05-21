<?php

use Redot\Validator\Validator;

test('Between: valid case', function () {
    expect(Validator::between(5, 1, 10))->toBe(true);
});

test('Between: invalid case', function () {
    expect(Validator::between(5, 1, 2))->toBe(false);
});
