<?php
/**
 * Created by enea dhack - 12/07/2020 11:19.
 */

namespace Vaened\Enum;

class Attributor
{
    private string $case;

    private array $attributes;

    public function __construct(string $case, array $attributes)
    {
        $this->case = $case;
        $this->attributes = $attributes;
    }

    public static function to(string $case, array $attributes): static
    {
        return new static($case, $attributes);
    }

    public function getCase(): string
    {
        return $this->case;
    }

    public function getAttributes(): array
    {
        return $this->attributes;
    }
}
