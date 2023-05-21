<?php

use Redot\Validator\Validator;

test('Contains: valid case (string)', function () {
    expect(Validator::contains('abc', 'a', 'b'))->toBe(true);
});

test('Contains: invalid case (string)', function () {
    expect(Validator::contains('abc', 'd'))->toBe(false);
});

test('Contains: valid case (array)', function () {
    expect(Validator::contains(['a'], 'a'))->toBe(true);
});

test('Contains: invalid case (array)', function () {
    expect(Validator::contains(['a'], 'd'))->toBe(false);
});

test('Contains: valid case (object)', function () {
    expect(Validator::contains((object) ['a' => 'a'], 'a'))->toBe(true);
});

test('Contains: invalid case (object)', function () {
    expect(Validator::contains((object) ['a' => 'a'], 'd'))->toBe(false);
});
