<?php

use Validator\Validator;

test('Min: valid case (number)', function () {
    expect(Validator::init(6)->min(5)->validate())->toBe(true);
});

test('Min: valid case (array)', function () {
    expect(Validator::init([1])->min(1)->validate())->toBe(true);
});

test('Min: valid case (string)', function () {
    expect(Validator::init('test')->min(4)->validate())->toBe(true);
});

test('Min: invalid case (number)', function () {
    expect(Validator::init(5)->min(6)->validate())->toBe(false);
});

test('Min: invalid case (array)', function () {
    expect(Validator::init([])->min(1)->validate())->toBe(false);
});

test('Min: invalid case (string)', function () {
    expect(Validator::init('test')->min(5)->validate())->toBe(false);
});