<?php

use Redot\Validator\Validator;

test('Each: valid case', function () {
    expect(Validator::init([1, 2, 3])->each(fn ($a) => is_numeric($a))->validate())
        ->toBe(true);
});

test('Each: invalid case', function () {
    expect(Validator::init([1, 2, 'a'])->each(fn ($a) => is_numeric($a))->validate())
        ->toBe(false);
});

it('throws an exception if the callback is not callable', function () {
    $closure = function () {
        Validator::init([1, 2, 3])->each('not callable');
    };

    expect($closure)->toThrow(InvalidArgumentException::class);
});

it('throws an exception if the value is not traversable', function () {
    $closure = function () {
        Validator::init('not traversable')->each(fn ($a) => is_numeric($a));
    };

    expect($closure)->toThrow(InvalidArgumentException::class);
});