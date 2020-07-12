<?php
/**
 * Created by enea dhack - 08/07/2020 17:01.
 */

namespace Vaened\Enum;

interface Enumerable
{
    public function key(): string;

    public function value(): string;

    public function equals(string $value): bool;
}