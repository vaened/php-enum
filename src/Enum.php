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

    private array $attributes;

    private static array $cache = [];

    public function __construct(string $value)
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

    protected function attributes(): array
    {
        return [];
    }

    protected function attribute(string $name): ?string
    {
        $params = $this->getEnumAttributes();
        return $params[$name] ?? null;
    }

    protected function getEnumAttributes(): array
    {
        return $this->attributes ??= $this->bindAttributes();
    }

    protected function bindAttributes(): array
    {
        $constant = array_reduce($this->attributes(), function (array $acc, Attribute $attribute): array {
            $acc[$attribute->getConstantName()] = $attribute->getAttributes();
            return $acc;
        }, []);

        return $constant[$this->key()] ?? [];
    }

    public static function __callStatic(string $name, array $arguments): self
    {
        $values = static::associates();

        if (isset($values[$name])) {
            return new static($values[$name]);
        }

        throw new BadMethodCallException("No static method or enum constant '$name' in enum " . static::class);
    }

    public function __toString(): string
    {
        return $this->value();
    }
}

