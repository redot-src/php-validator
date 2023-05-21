<?php

use Redot\Validator\Validator;

test('String: valid case', function () {
    expect(Validator::string('test'))->toBe(true);
});

test('String: invalid case', function () {
    expect(Validator::string(123))->toBe(false);
});
