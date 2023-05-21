<?php

use Redot\Validator\Validator;
use Redot\Validator\Rules\TypeOfRule;

test('TypeOf: valid case (integer)', function () {
    expect(Validator::typeOf(1, TypeOfRule::TYPE_INTEGER))->toBe(true);
});

test('TypeOf: invalid case (integer)', function () {
    expect(Validator::typeOf(null, TypeOfRule::TYPE_INTEGER))->toBe(false);
});

test('TypeOf: valid case (double)', function () {
    expect(Validator::typeOf(1.1, TypeOfRule::TYPE_DOUBLE))->toBe(true);
});

test('TypeOf: invalid case (double)', function () {
    expect(Validator::typeOf(null, TypeOfRule::TYPE_DOUBLE))->toBe(false);
});

test('TypeOf: valid case (string)', function () {
    expect(Validator::typeOf('abc', TypeOfRule::TYPE_STRING))->toBe(true);
});

test('TypeOf: invalid case (string)', function () {
    expect(Validator::typeOf(null, TypeOfRule::TYPE_STRING))->toBe(false);
});

test('TypeOf: valid case (boolean)', function () {
    expect(Validator::typeOf(true, TypeOfRule::TYPE_BOOLEAN))->toBe(true);
});

test('TypeOf: invalid case (boolean)', function () {
    expect(Validator::typeOf(null, TypeOfRule::TYPE_BOOLEAN))->toBe(false);
});

test('TypeOf: valid case (array)', function () {
    expect(Validator::typeOf([], TypeOfRule::TYPE_ARRAY))->toBe(true);
});

test('TypeOf: invalid case (array)', function () {
    expect(Validator::typeOf(null, TypeOfRule::TYPE_ARRAY))->toBe(false);
});

test('TypeOf: valid case (object)', function () {
    expect(Validator::typeOf(new stdClass(), TypeOfRule::TYPE_OBJECT))->toBe(true);
});

test('TypeOf: invalid case (object)', function () {
    expect(Validator::typeOf(null, TypeOfRule::TYPE_OBJECT))->toBe(false);
});

test('TypeOf: valid case (resource)', function () {
    expect(Validator::typeOf(fopen('php://memory', 'r'), TypeOfRule::TYPE_RESOURCE))->toBe(true);
});

test('TypeOf: invalid case (resource)', function () {
    expect(Validator::typeOf(null, TypeOfRule::TYPE_RESOURCE))->toBe(false);
});

test('TypeOf: valid case (null)', function () {
    expect(Validator::typeOf(null, TypeOfRule::TYPE_NULL))->toBe(true);
});

test('TypeOf: invalid case (null)', function () {
    expect(Validator::typeOf('', TypeOfRule::TYPE_NULL))->toBe(false);
});
