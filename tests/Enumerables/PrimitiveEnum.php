<?php
/**
 * Created by enea dhack.
 */

namespace Vaened\Enum\Tests\Enumerables;

use Vaened\Enum\Enum;

/**
 * Class PrimitiveEnum
 *
 * @package Vaened\Enum\Tests\Enumerables
 * @author enea dhack <enea.so@live.com>
 *
 * @method static PrimitiveEnum INTEGER()
 * @method static PrimitiveEnum BOOLEAN()
 * @method static PrimitiveEnum FLOAT()
 * @method static PrimitiveEnum STRING()
 */
class PrimitiveEnum extends Enum
{
    public const INTEGER = 1;

    public const BOOLEAN = true;

    public const FLOAT = 2.1;

    public const STRING = 'string';
}
