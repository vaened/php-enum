<?php
/**
 * Created by enea dhack.
 */

namespace Vaened\Enum\Tests\Enumerables;

use Vaened\Enum\Enum;

/**
 * Class Code
 *
 * @package Vaened\Enum\Tests\Enumerables
 * @author enea dhack <enea.so@live.com>
 *
 * @method static Code NOT_FOUND()
 * @method static Code UNAUTHORIZED()
 */
class Code extends Enum
{
    public const NOT_FOUND = 404;

    public const UNAUTHORIZED = 403;
}
