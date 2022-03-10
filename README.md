# PHP Validator

*Validation framework that let you configure, rather than code, your validation logic.*

## Installation:
```sh
composer require abdelrhmansaid/validator
```

## Usage:

```php
$errors = Validator::init($email)->required()->email()->errors(); // array

// Or create new Validator instance
$validator = new Validator($email);
$validator->required()->email();

var_dump($validator->errors()); // array
var_dump($validator->validate()); // bool

// Also you can validate multiple values
Validator::initMultiple($_POST, [
    'email' => 'required|email',
]);
```

## Default Validators

- `required`
- `email`
- `pattern`
- `min`
- `max`
- `equal`
- `ext`
- `date`
- `alpha`
- `between`
- `contains`
- `doesntContain`
- `string`
- `integer`
- `double`
- `array`
- `object`

Also, you can create your specific rule by extending `Rule` class

## Create Rule

You can create any rule by extending `Rule` class, and write your custom validation code under `check` method

Example:

```php
// Create new Rule
class UserExist extends Rule
{
    public string $name = 'exist'; // Custom rule name

    public function check(mixed $value, mixed ...$params): bool
    {
        return DB::query('SELECT * FROM users WHERE id = ?', $value)->numRows === 0;
    }
}

// Register custom rule
Validator::register(UserExist::class);

// Use custom rule
Validator::init($userId)->rule('exist')->errors(); // array
```

## Get Validation result

If you just want to know if `$value` is valid or not, You can use `$validator->validate()` method,
On the other hand if you want to get all validation errors, you can use `$validator->errors()` method
that will return an array contains all validation failures.
