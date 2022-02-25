# PHP Validator

*Validation framework that let's you configure, rather than code, your validation logic.*

Usage example:

```php
$errors = Validator::init($email)->required()->email()->errors(); // array

// Or create new Validator instance
$validator = new Validator($email);
$validator->required()->email();

print_r($validator->errors()); // array
var_dump($validator->validate()); // bool
```

## Default Validators

- `required`
- `email`
- `pattern`
- `min`
- `max`
- `in`
- `contains`
- `notContains`
- `string`
- `integer`
- `double`
- `array`
- `object`

Also you can create your specific rule by extending `Rule` class

## Create Rule

You can create any rule by extending `Rule` class, and write your custom validation code under `check` method

Example:

```php
class UserExist extends Rule
{
    public string $name = 'exist'; // Custom rule name

    public function check(mixed $value): bool
    {
        return DB::exist($value, 'users');
    }
}
```

## Get Validation result

If you just want to know if `$value` is valid or not, Just use `$validator->validate()` method, On the other hand if you would like to get all errors you can use `$validator->errors()` method that will return an assoc array where `$key` is the rule name, and `$value` is false by default.