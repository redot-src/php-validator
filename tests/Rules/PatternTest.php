<?php

use Redot\Validator\Validator;

test('Pattern: valid case', function () {
    expect(Validator::init('test')->pattern('/^[a-z]+$/')->validate())->toBe(true);
});

test('Pattern: invalid case', function () {
    expect(Validator::init('TEST')->pattern('/^[a-z]+$/')->validate())->toBe(false);
});