# PHP Enum

[![Build Status](https://travis-ci.org/vaened/php-enum.svg?branch=master)](https://travis-ci.org/vaened/php-enum
) [![Scrutinizer Code Quality](https://scrutinizer-ci.com/g/vaened/php-enum/badges/quality-score.png?b=master)](https://scrutinizer-ci.com/g/vaened/php-enum/?branch=master) [![Software License](https://img.shields.io/badge/license-MIT-brightgreen.svg?style=flat-square)](LICENSE.md) 

Friendly enumeration implementation.

```php
$status = Status::WARNING();

$status->key(); // WARNING
$status->value(); // Advertencia

// custom attribute
$status->getColor(); // yellow
```

## Installation

PHP Enum requires PHP 8.

To get the latest version, simply require the project using Composer:
```sh
$ composer require vaened/php-enum
```

## Declaration

To create an enumeration it is necessary to extend from [`Vaened\Enum\Enum`](https://github.com/vaened/php-enum/blob/master/src/Enum.php), in addition to creating constants for each value of the enumeration. This library has the ability to add attributes for each enumeration, very similar to the enumerations in java.

```php
<?php namespace App\Enums;

use App\Color;
use Vaened\Enum\Attributor;
use Vaened\Enum\Enum;

class Status extends Enum
{
    // Enums
    public const WARNING = 'Advertencia';

    public const SUCCESS = 'Exito';
}
```

## Usage

Once the enumeration is implemented, you can use its values in the following way. The library uses [`__callStatic`](https://www.php.net/manual/en/language.oop5.overloading.php#object.callstatic) to create instances of a specified enumeration, according to the requested value.

```php
use App\Enums\Status;

// returns an instance of Status, with the value of the constant WARNING
Status::WARNING();
```

In case you want autocompletion ID, you can define the methods manually.

```php
class Status extends Enum
{
    public const WARNING = 'Advertencia';

    public static function WARNING(): self 
    {
        return self::create(self::WARNING);
    }
}
```

or if you are using some ID that supports phpdocs, you can do something like this:

```php
/**
 * Class Status
 *
 * @method static Status WARNING()
 */
class Status extends Enum
{
    public const WARNING = 'Advertencia';
}
```

### Advanced

There may be specific cases where you need to add some additional attribute to the enumeration. To do this, you will need to override the protected static method **attributes** available in all `Enum` children, here you must define the attributes you will use for each enumeration.

> Must use the [`Vaened\Enum\Attributor`](https://github.com/vaened/php-enum/blob/master/src/Attributor.php) class.

```php 
Attributor::to('CONSTANT', [
    'name' => 'value'
]);
```

To get any attribute, you can use the protected method **attribute** which gets the name of the attribute as parameter

```php
class Status extends Enum
{
    public const SUCCESS = 'Éxito';

    public function getColor(): Color
    {
        return $this->attribute('color');
    }

    protected static function attributes(): array
    {
        return [
            Attributor::to('SUCCESS', [
                'color' => new Color('blue'),
            ]),
        ];
    }
}
```

## API

| Method                                    | Description                                                  | Returns   |
| ----------------------------------------- | ------------------------------------------------------------ | --------- |
| **static::create(string $value)**         | Create an instance for the given value.                      | `Enum`    |
| **static::instantiate(string $constant)** | Instantiate from constant name.                              | `Enum`    |
| **static::isValid(string $value)**        | Check if the given value belongs to the enumaracion.         | `boolean` |
| **static::values()**                      | Returns an `array` with all the enumeration values.          | `Enum[]`  |
| **$instance->value()**                    | Returns the value of an enumeration.                         | `string`  |
| **$instance->key()**                      | Returns the constant name of an enumeration.                 | `string`  |
| **$instance->equals(string $value)**      | Verify that the value of an enumeration is equal to a given value. | `boolean` |

## More documentation

You can find a lot of comments within the source code as well as the tests located in the `tests` directory.