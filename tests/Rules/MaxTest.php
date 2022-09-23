<?php

use Redot\Validator\Validator;

test('Max: valid case (number)', function () {
    expect(Validator::max(5, 6))->toBe(true);
});

test('Max: invalid case (number)', function () {
    expect(Validator::max(6, 5))->toBe(false);
});

test('Max: valid case (array)', function () {
    expect(Validator::max([], 2))->toBe(true);
});

test('Max: invalid case (array)', function () {
    expect(Validator::max([1, 2], 1))->toBe(false);
});

test('Max: valid case (string)', function () {
    expect(Validator::max('test', 4))->toBe(true);
});

test('Max: invalid case (string)', function () {
    expect(Validator::max('test', 3))->toBe(false);
});