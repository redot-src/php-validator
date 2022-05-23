<?php

use Redot\Validator\Validator;

test('Max: valid case (number)', function () {
    expect(Validator::init(5)->max(6)->validate())->toBe(true);
});

test('Max: valid case (array)', function () {
    expect(Validator::init([])->max(2)->validate())->toBe(true);
});

test('Max: valid case (string)', function () {
    expect(Validator::init('test')->max(4)->validate())->toBe(true);
});

test('Max: invalid case (number)', function () {
    expect(Validator::init(6)->max(5)->validate())->toBe(false);
});

test('Max: invalid case (array)', function () {
    expect(Validator::init([1, 2])->max(1)->validate())->toBe(false);
});

test('Max: invalid case (string)', function () {
    expect(Validator::init('test')->max(3)->validate())->toBe(false);
});