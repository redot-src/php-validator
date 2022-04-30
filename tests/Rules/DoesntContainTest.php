<?php

use Validator\Validator;

test('DoesntContain: valid case (string)', function () {
    expect(Validator::init('abc')->doesntContain('d')->validate())->toBe(true);
});

test('DoesntContain: invalid case (string)', function () {
    expect(Validator::init('abc')->doesntContain('a', 'b')->validate())->toBe(false);
});

test('DoesntContain: valid case (array)', function () {
    expect(Validator::init(['a'])->doesntContain('d')->validate())->toBe(true);
});

test('DoesntContain: invalid case (array)', function () {
    expect(Validator::init(['a'])->doesntContain('a')->validate())->toBe(false);
});

test('DoesntContain: valid case (object)', function () {
    expect(Validator::init((object) ['a' => 'a'])->doesntContain('d')->validate())->toBe(true);
});

test('DoesntContain: invalid case (object)', function () {
    expect(Validator::init((object) ['a' => 'a'])->doesntContain('a')->validate())->toBe(false);
});