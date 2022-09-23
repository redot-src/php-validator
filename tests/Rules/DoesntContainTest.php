<?php

use Redot\Validator\Validator;

test('DoesntContain: valid case (string)', function () {
    expect(Validator::doesntContain('abc', 'd'))->toBe(true);
});

test('DoesntContain: invalid case (string)', function () {
    expect(Validator::doesntContain('abc', 'a', 'b'))->toBe(false);
});

test('DoesntContain: valid case (array)', function () {
    expect(Validator::doesntContain(['a'], 'd'))->toBe(true);
});

test('DoesntContain: invalid case (array)', function () {
    expect(Validator::doesntContain(['a'], 'a'))->toBe(false);
});

test('DoesntContain: valid case (object)', function () {
    expect(Validator::doesntContain((object) ['a' => 'a'], 'd'))->toBe(true);
});

test('DoesntContain: invalid case (object)', function () {
    expect(Validator::doesntContain((object) ['a' => 'a'], 'a'))->toBe(false);
});