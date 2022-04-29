<?php

use Validator\Validator;
use Validator\Rules\EmailRule;

Validator::registerRule(EmailRule::class);

test('Email: valid case', function () {
    expect(Validator::init('test@vendor.com')->email()->validate())->toBe(true);
});

test('Email: invalid case', function () {
    expect(Validator::init('test')->email()->validate())->toBe(false);
});