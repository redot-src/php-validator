<?php

use Validator\Validator;

test('Email: valid case', function () {
    expect(Validator::init('test@vendor.com')->email()->validate())->toBe(true);
});

test('Email: invalid case', function () {
    expect(Validator::init('test')->email()->validate())->toBe(false);
});