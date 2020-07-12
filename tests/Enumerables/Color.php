<?php
/**
 * Created by enea dhack - 12/07/2020 15:46.
 */

namespace Vaened\Enum\Tests\Enumerables;

final class Color
{
    private string $color;

    public function __construct(string $color)
    {
        $this->color = $color;
    }

    public function getName(): string
    {
        return $this->color;
    }
}
