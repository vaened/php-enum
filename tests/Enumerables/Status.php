<?php
/**
 * Created by enea dhack - 08/07/2020 19:14.
 */

namespace Vaened\Enum\Tests\Enumerables;

use Vaened\Enum\Attribute;
use Vaened\Enum\Enum;

/**
 * Class Status
 *
 * @package Vaened\Enum\Tests\Enumerables
 * @author enea dhack <enea.so@live.com>
 *
 * @method static Status WARNING()
 * @method static Status SUCCESS()
 */
class Status extends Enum
{
    public const WARNING = 'Advertencia';

    public const SUCCESS = 'Exito';

    public function getColor(): string
    {
        return $this->attribute('color');
    }

    protected static function attributes(): array
    {
        return [
            Attribute::to('WARNING')->add('color', 'yellow'),
            Attribute::to('SUCCESS')->add('color', 'blue'),
        ];
    }
}
