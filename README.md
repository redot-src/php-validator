# PHP Validator

*Validation framework that let you configure, rather than code, your validation logic.*

## Installation

```sh
composer require abdelrhmansaid/validator
```

## Testing

```sh
composer test
```

## Usage

After registering rules that you want to use, you can use the validator like this:

```php

use Validator\Validator;

/* Inistantiate a new validator */
$validator = new Validator($email);

/* Or you can use the static method init */
$validator = Validator::init($email);

/* Apply your rules */
$validator->email()->required()->max(255);

if (!$validator->validate()) {
    return $validator; // validation result in JSON format
}

```

Also you can validate multiple values at once:

```php

$errors = Validator::initMultiple($_POST, [
    'email' => 'email',
    'password' => 'required|min:6|max:255'
]);

if (count($errors)) {
    // do something
}

```

*Note that multiple validations returns an array of failures rather than a Validator instance.*

## Registering rules

Validator by default came without any registered rules. You can add them by using the `Validator::registerRule()` method.

```php

use Validator\Rules\RequiredRule;

Validator::registerRule(RequiredRule::class);

```

## Pre-defined rules

Heres a list of pre-defined rules:
- `Alpha`
- `Between`
- `Contains`
- `DoesntContain`
- `Equal`
- `Email`
- `IsDate`
- `Max`
- `Min`
- `Pattern`
- `Required`

*You can submit a pull request to add a new rule.*

## Custom rules

If you have a specific rule that you want to use, you can create a class that extends `Validator\AbstractRule` and register it.

```php

class CustomRule extends AbstractRule
{
    protected string $message = '...';

    public function getName(): string
    {
        // name will be used to call the rule
    }

    public function validate(mixed $value, mixed ...$params): bool
    {
        // validation logic
    }
}

```

## Custom messages

If you want to customize the error messages, you can use the `Validator::setMessages()` method.

```php

Validator::setMessages([
    'required' => 'The value is required.',
    'email' => 'The value is not a valid email.'
    'max' => 'The value should be less than or equal to {0}.',
]);

```

*Note that you can pass parameters to the message using `{x}` placeholders where `x` is the index of the parameter.*

That's it, Enjoy 👌!