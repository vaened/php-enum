<?php
/**
 * Created by enea dhack - 08/07/2020 16:59.
 */

namespace Vaened\Enum;

use BadMethodCallException;
use ReflectionClass;
use Stringable;
use UnexpectedValueException;
use function array_reduce;

abstract class Enum implements Enumerable, Stringable
{
    private string $value;

    private static array $attributes = [];

    private static array $cache = [];

    final private function __construct(string $value)
    {
        if (! self::isValid($value)) {
            throw new UnexpectedValueException("Value '$value' is not part of the enum " . static::class);
        }

        $this->value = $value;
    }

    public static function create(string $value): static
    {
        return new static($value);
    }

    public static function instantiate(string $key): static
    {
        $values = static::associates();

        if (! isset($values[$key])) {
            throw new UnexpectedValueException("Key '$key' is not part of the enum " . static::class);
        }

        return static::create($values[$key]);
    }

    public static function isValid(string $value): bool
    {
        return in_array($value, static::associates(), true);
    }

    public static function values(): array
    {
        return array_map(static fn(string $value) => static::create($value), static::associates());
    }

    private static function associates(): array
    {
        $classname = static::class;
        return self::$cache[$classname] ??= static::getConstantsFrom($classname);
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
        return array_reduce(static::attributes(), static function (array $acc, Attributor $attribute): array {
            $acc[$attribute->getCase()] = $attribute->getAttributes();
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

    protected function attribute(string $name): mixed
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

