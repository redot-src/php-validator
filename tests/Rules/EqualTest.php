<?php

use Redot\Validator\Validator;

test('Equal: valid case', function () {
    expect(Validator::equal('test', 'test'))->toBe(true);
});

test('Equal: invalid case', function () {
    expect(Validator::equal('test', 'test2'))->toBe(false);
});
