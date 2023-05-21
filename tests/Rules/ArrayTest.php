<?php

use Redot\Validator\Validator;

test('Array: valid case', function () {
    expect(Validator::array(['foo', 'bar']))->toBe(true);
});

test('Array: invalid case', function () {
    expect(Validator::array('test'))->toBe(false);
});
