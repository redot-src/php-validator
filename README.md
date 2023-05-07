# PHP Validator

[![tests](https://github.com/AbdelrhmanSaid/php-validator/actions/workflows/php.yml/badge.svg)](https://github.com/AbdelrhmanSaid/php-validator/actions/workflows/php.yml)

*Validation library lets you configure, rather than code, your validation logic.*

## Installation

```sh
composer require redot/validator
```

## Testing

```sh
composer test
```

## Usage

After registering the rules that you want to use, you can use the validator like this:

```php
use Redot\Validator\Validator;

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

Btw, you can validate values statically:

```php
$isEmail = Validator::email('admin@example.com'); // true
```

## Registering rules

The validator came without any registered rules by default. You can add them by using the `Validator::addRule()` method.

```php
use Redot\Validator\Rules\RequiredRule;

Validator::addRule(RequiredRule::class);
```

Also you can load the default rules by using the `Validator::loadDefaultRules()` method.

```php
Validator::loadDefaultRules();
```

Loading the default rules will register the following rules:

| Rule | Description | Parameters |
| --- | --- | --- |
| `alpha` | The value must contain only alphabetic characters. | - |
| `between` | The value must be between the given min and max. | `min`, `max` |
| `contains` | The value must contain the given string. | `string\|array\|object` |
| `doesntContain` | The value must not contain the given string. | `string\|array\|object` |
| `each` | The value must be an array and each item must pass the given rule. | `rule` |
| `email` | The value must be a valid email address. | - |
| `equal` | The value must be equal to the given value. | `value` |
| `isDate` | The value must be a valid date. | - |
| `max` | The value must be less than or equal to the given value. | `value` |
| `min` | The value must be greater than or equal to the given value. | `value` |
| `pattern` | The value must match the given pattern. | `pattern` |
| `required` | The value must be present. | - |
| `typeOf` | The value must be of the given type. | `type` |

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
    'email' => 'The value is not a valid email.',
    'max' => 'The value should be less than or equal to {0}.',
]);
```

*Note that you can pass parameters to the message using `{x}` placeholders where `x` is the index of the parameter.*

That's it. Enjoy 👌!
