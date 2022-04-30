<?php

use Validator\Validator;

$baseRules = [
    \Validator\Rules\AlphaRule::class,
    \Validator\Rules\EmailRule::class,
    \Validator\Rules\EqualRule::class,
    \Validator\Rules\IsDateRule::class,
    \Validator\Rules\MaxRule::class,
    \Validator\Rules\MinRule::class,
    \Validator\Rules\PatternRule::class,
    \Validator\Rules\RequiredRule::class,
];

foreach ($baseRules as $rule) {

    if (!Validator::hasRule($rule)) {
        Validator::registerRule($rule);
    }
}