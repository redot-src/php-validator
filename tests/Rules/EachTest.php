<?php

use Redot\Validator\Validator;

test('Each: valid case', function () {
    expect(Validator::each([1, 2, 3], fn ($a) => is_numeric($a)))->toBe(true);
});

test('Each: invalid case', function () {
    expect(Validator::each([1, 2, 'a'], fn ($a) => is_numeric($a)))->toBe(false);
});

it('throws an exception if the callback is not callable', function () {
    $closure = function () {
        Validator::each([1, 2, 3], 'not callable');
    };

    expect($closure)->toThrow(InvalidArgumentException::class);
});

it('throws an exception if the value is not traversable', function () {
    $closure = function () {
        Validator::each('not traversable', fn ($a) => is_numeric($a));
    };

    expect($closure)->toThrow(InvalidArgumentException::class);
});
