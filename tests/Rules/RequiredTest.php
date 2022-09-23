<?php

use Redot\Validator\Validator;

test('Required: valid case', function () {
    expect(Validator::required('foo'))->toBe(true);
});

test('Required: invalid case', function () {
    expect(Validator::required(''))->toBe(false);
});