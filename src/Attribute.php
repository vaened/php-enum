<?php
/**
 * Created by enea dhack - 12/07/2020 11:19.
 */

namespace Vaened\Enum;

class Attribute
{
    private string $constantName;

    private array $attributes;

    public function __construct(string $constantName, array $attributes = [])
    {
        $this->constantName = $constantName;
        $this->attributes = $attributes;
    }

    public static function to(string $constantName): self
    {
        return new static($constantName);
    }

    public function add(string $name, string $value): self
    {
        $this->attributes[$name] = $value;
        return $this;
    }

    public function getConstantName(): string
    {
        return $this->constantName;
    }

    public function getAttributes(): array
    {
        return $this->attributes;
    }
}
