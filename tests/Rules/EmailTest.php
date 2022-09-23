<?php

use Redot\Validator\Validator;

test('Email: valid case', function () {
    expect(Validator::email('test@vendor.com'))->toBe(true);
});

test('Email: invalid case', function () {
    expect(Validator::email('test'))->toBe(false);
});