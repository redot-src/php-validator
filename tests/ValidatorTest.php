<?php

use Validator\Validator;

test('Rule: required', function () {
    expect(Validator::init('')->required()->validate())->toBe(false);
    expect(Validator::init('value')->required()->validate())->toBe(true);
});

test('Rule: email', function () {
    expect(Validator::init('invalid email')->email()->validate())->toBe(false);
    expect(Validator::init('example@gmail.com')->email()->validate())->toBe(true);
});

test('Rule: pattern', function () {
    expect(Validator::init('fdff')->pattern('/[1-9]/')->validate())->toBe(false);
    expect(Validator::init('1234')->pattern('/[1-9]/')->validate())->toBe(true);
});

test('Rule: min', function () {
    expect(Validator::init(5)->min(8)->validate())->toBe(false);
    expect(Validator::init(5)->min(3)->validate())->toBe(true);
});

test('Rule: max', function () {
    expect(Validator::init(8)->max(5)->validate())->toBe(false);
    expect(Validator::init(3)->max(5)->validate())->toBe(true);
});

test('Rule: equal', function () {
    expect(Validator::init(8)->equal(5)->validate())->toBe(false);
    expect(Validator::init(3)->equal(3)->validate())->toBe(true);
    expect(Validator::init(3)->equal('3', true)->validate())->toBe(false);
    expect(Validator::init(3)->equal(3, true)->validate())->toBe(true);
});

test('Rule: ext', function () {
    expect(Validator::init('image.jpg')->ext('png')->validate())->toBe(false);
    expect(Validator::init('image.jpg')->ext('jpg')->validate())->toBe(true);
});

test('Rule: date', function () {
    expect(Validator::init('image.jpg')->date()->validate())->toBe(false);
    expect(Validator::init('1/1/2020')->date()->validate())->toBe(true);
});

test('Rule: alpha', function () {
    expect(Validator::init(12345)->alpha()->validate())->toBe(false);
    expect(Validator::init('abcd')->alpha()->validate())->toBe(true);
});

test('Rule: between', function () {
    expect(Validator::init(5)->between(10, 15)->validate())->toBe(false);
    expect(Validator::init(5)->between(1, 6)->validate())->toBe(true);
});

test('Rule: contains', function () {
    expect(Validator::init([1, 2, 3, 4])->contains(16)->validate())->toBe(false);
    expect(Validator::init([1, 2, 3, 4])->contains(3)->validate())->toBe(true);
});

test('Rule: doesntContain', function () {
    expect(Validator::init([1, 2, 3, 4])->doesntContain(3)->validate())->toBe(false);
    expect(Validator::init([1, 2, 3, 4])->doesntContain(16)->validate())->toBe(true);
});

test('Rule: string', function () {
    expect(Validator::init([1, 2, 3, 4])->string()->validate())->toBe(false);
    expect(Validator::init('')->string()->validate())->toBe(true);
});

test('Rule: integer', function () {
    expect(Validator::init('')->integer()->validate())->toBe(false);
    expect(Validator::init(5)->integer()->validate())->toBe(true);
});

test('Rule: double', function () {
    expect(Validator::init(5)->double()->validate())->toBe(false);
    expect(Validator::init(5.2)->double()->validate())->toBe(true);
});

test('Rule: array', function () {
    expect(Validator::init(5)->array()->validate())->toBe(false);
    expect(Validator::init([])->array()->validate())->toBe(true);
});

test('Rule: object', function () {
    expect(Validator::init([])->object()->validate())->toBe(false);
    expect(Validator::init(new stdClass)->object()->validate())->toBe(true);
});

test('Rule: truthy', function () {
    expect(Validator::init(0)->truthy()->validate())->toBe(false);
    expect(Validator::init(1)->truthy()->validate())->toBe(true);
});

test('Rule: falsy', function () {
    expect(Validator::init(1)->falsy()->validate())->toBe(false);
    expect(Validator::init(0)->falsy()->validate())->toBe(true);
});