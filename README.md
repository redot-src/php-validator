# PHP Validator

*Validation framework lets you configure, rather than code, your validation logic.*

## Installation

```sh
composer require abdelrhmansaid/validator
```

## Testing

```sh
composer test
```

## Usage

After registering the rules that you want to use, you can use the validator like this:

```php

use Validator\Validator;

/* Instantiate a new validator */
$validator = new Validator($email);

/* Or you can use the static method init */
$validator = Validator::init($email);

/* Apply your rules */
$validator->email()->required()->max(255);

if (!$validator->validate()) {
    return $validator; // validation result in JSON format
}

```

Also, you can validate multiple values at once:

```php

$errors = Validator::initMultiple($_POST, [
    'email' => 'email',
    'password' => 'required|min:6|max:255'
]);

if (count($errors)) {
    // do something
}

```

*Note that multiple validations return an array of failures rather than a Validator instance.*

## Registering rules

The validator came without any registered rules by default. You can add them by using the `Validator::registerRule()` method.

```php

use Validator\Rules\RequiredRule;

Validator::registerRule(RequiredRule::class);

```

## Pre-defined rules

Here's a list of pre-defined rules:
- `Alpha` => Check if the value is alphabetic
- `Between` => Check if the value is between two values
- `Contains` => Check if the value contains another value
- `DoesntContain` => Check if the value doesn't contain another value
- `Each` => Check if each value is valid
- `Equal` => Check if the value is equal to another value
- `Email` => Check if the value is a valid email
- `IsDate` => Check if the value is a valid date
- `Max` => Check if the value is less than or equal to another value
- `Min` => Check if the value is greater than or equal to another value
- `Pattern` => Check if the value matches a regular expression
- `Required` => Check if the value is not empty

*You can submit a pull request to add a new rule.*

## Custom rules

If you have a specific rule you want to use, you can create a class that extends `Validator\AbstractRule` and register it.

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

That's it. Enjoy 👌!