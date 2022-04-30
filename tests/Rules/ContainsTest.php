<?php

use Validator\Validator;

test('Contains: valid case (string)', function () {
    expect(Validator::init('abc')->contains('a')->validate())->toBe(true);
});

test('Contains: invalid case (string)', function () {
    expect(Validator::init('abc')->contains('d')->validate())->toBe(false);
});

test('Contains: valid case (array)', function () {
    expect(Validator::init(['a'])->contains('a')->validate())->toBe(true);
});

test('Contains: invalid case (array)', function () {
    expect(Validator::init(['a'])->contains('d')->validate())->toBe(false);
});

test('Contains: valid case (object)', function () {
    expect(Validator::init((object) ['a' => 'a'])->contains('a')->validate())->toBe(true);
});

test('Contains: invalid case (object)', function () {
    expect(Validator::init((object) ['a' => 'a'])->contains('d')->validate())->toBe(false);
});