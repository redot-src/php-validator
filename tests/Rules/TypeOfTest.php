<?php

use Redot\Validator\Validator;
use Redot\Validator\Rules\TypeOfRule;

test('TypeOf: valid case (integer)', function () {
    expect(Validator::init(1)->typeOf(TypeOfRule::TYPE_INTEGER)->validate())->toBe(true);
});

test('TypeOf: invalid case (integer)', function () {
    expect(Validator::init()->typeOf(TypeOfRule::TYPE_DOUBLE)->validate())->toBe(false);
});

test('TypeOf: valid case (double)', function () {
    expect(Validator::init(1.1)->typeOf(TypeOfRule::TYPE_DOUBLE)->validate())->toBe(true);
});

test('TypeOf: invalid case (double)', function () {
    expect(Validator::init()->typeOf(TypeOfRule::TYPE_INTEGER)->validate())->toBe(false);
});

test('TypeOf: valid case (string)', function () {
    expect(Validator::init('abc')->typeOf(TypeOfRule::TYPE_STRING)->validate())->toBe(true);
});

test('TypeOf: invalid case (string)', function () {
    expect(Validator::init()->typeOf(TypeOfRule::TYPE_DOUBLE)->validate())->toBe(false);
});

test('TypeOf: valid case (boolean)', function () {
    expect(Validator::init(true)->typeOf(TypeOfRule::TYPE_BOOLEAN)->validate())->toBe(true);
});

test('TypeOf: invalid case (boolean)', function () {
    expect(Validator::init()->typeOf(TypeOfRule::TYPE_DOUBLE)->validate())->toBe(false);
});

test('TypeOf: valid case (array)', function () {
    expect(Validator::init([])->typeOf(TypeOfRule::TYPE_ARRAY)->validate())->toBe(true);
});

test('TypeOf: invalid case (array)', function () {
    expect(Validator::init()->typeOf(TypeOfRule::TYPE_DOUBLE)->validate())->toBe(false);
});

test('TypeOf: valid case (object)', function () {
    expect(Validator::init(new stdClass())->typeOf(TypeOfRule::TYPE_OBJECT)->validate())->toBe(true);
});

test('TypeOf: invalid case (object)', function () {
    expect(Validator::init()->typeOf(TypeOfRule::TYPE_DOUBLE)->validate())->toBe(false);
});

test('TypeOf: valid case (resource)', function () {
    expect(Validator::init(fopen('php://memory', 'r'))->typeOf(TypeOfRule::TYPE_RESOURCE)->validate())->toBe(true);
});

test('TypeOf: invalid case (resource)', function () {
    expect(Validator::init()->typeOf(TypeOfRule::TYPE_DOUBLE)->validate())->toBe(false);
});

test('TypeOf: valid case (null)', function () {
    expect(Validator::init(null)->typeOf(TypeOfRule::TYPE_NULL)->validate())->toBe(true);
});

test('TypeOf: invalid case (null)', function () {
    expect(Validator::init('')->typeOf(TypeOfRule::TYPE_DOUBLE)->validate())->toBe(false);
});