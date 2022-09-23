<?php

use Redot\Validator\Validator;

test('Pattern: valid case', function () {
    expect(Validator::pattern('test', '/^[a-z]+$/'))->toBe(true);
});

test('Pattern: invalid case', function () {
    expect(Validator::pattern('TEST', '/^[a-z]+$/'))->toBe(false);
});