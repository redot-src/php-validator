<?php

use Redot\Validator\Validator;

test('Min: valid case (number)', function () {
    expect(Validator::min(6, 5))->toBe(true);
});

test('Min: invalid case (number)', function () {
    expect(Validator::min(5, 6))->toBe(false);
});

test('Min: valid case (array)', function () {
    expect(Validator::min([1], 1))->toBe(true);
});

test('Min: invalid case (array)', function () {
    expect(Validator::min([], 1))->toBe(false);
});

test('Min: valid case (string)', function () {
    expect(Validator::min('test', 4))->toBe(true);
});

test('Min: invalid case (string)', function () {
    expect(Validator::min('test', 5))->toBe(false);
});
