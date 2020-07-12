<?php
/**
 * Created by enea dhack - 08/07/2020 16:59.
 */

namespace Vaened\Enum;

use BadMethodCallException;
use ReflectionClass;
use UnexpectedValueException;

abstract class Enum implements Enumerable
{
    private string $value;

    private static array $attributes = [];

    private static array $cache = [];

    final private function __construct(string $value)
    {
        if (! $this->isValid($value)) {
            throw new UnexpectedValueException("Value '$value' is not part of the enum " . static::class);
        }

        $this->value = $value;
    }

    public static function create(string $value): self
    {
        return new static($value);
    }

    public static function instantiate(string $key): self
    {
        $values = static::associates();

        if (! isset($values[$key])) {
            throw new UnexpectedValueException("Key '$key' is not part of the enum " . static::class);
        }

        return self::create($values[$key]);
    }

    public static function isValid(string $value): bool
    {
        return in_array($value, static::associates(), true);
    }

    public static function values(): array
    {
        return array_map(fn(string $value) => self::create($value), static::associates());
    }

    private static function associates(): array
    {
        $classname = static::class;
        return self::$cache[$classname] ??= self::getConstantsFrom($classname);
    }

    private static function getConstantsFrom(string $classname): array
    {
        return (new ReflectionClass($classname))->getConstants();
    }

    private static function getEnumAttributes(): array
    {
        return self::$attributes[static::class] ??= static::bindEnumAttributes();
    }

    private static function bindEnumAttributes(): array
    {
        return array_reduce(static::attributes(), function (array $acc, Attribute $attribute): array {
            $acc[$attribute->getConstantName()] = $attribute->getAttributes();
            return $acc;
        }, []);
    }

    protected static function attributes(): array
    {
        return [];
    }

    public function value(): string
    {
        return $this->value;
    }

    public function key(): string
    {
        return array_search($this->value, static::associates(), true);
    }

    public function equals(string $value): bool
    {
        return $this->value() === $value;
    }

    protected function attribute(string $name)
    {
        $constants = static::getEnumAttributes();
        $attributes = $constants[$this->key()] ?? [];
        return $attributes[$name] ?? null;
    }

    public static function __callStatic(string $name, array $arguments): self
    {
        $values = static::associates();

        if (isset($values[$name])) {
            return static::create($values[$name]);
        }

        throw new BadMethodCallException("No static method or enum constant '$name' in enum " . static::class);
    }

    public function __toString(): string
    {
        return $this->value();
    }
}

