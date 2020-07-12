<?php
/**
 * Created by enea dhack - 12/07/2020 11:28.
 */

namespace Vaened\Enum\Tests;

use Vaened\Enum\Tests\Enumerables\Status;

class AttributesTest extends TestCase
{
    public function test_get_attribute(): void
    {
        $this->assertEquals('yellow', Status::WARNING()->getColor());
        $this->assertEquals('blue', Status::SUCCESS()->getColor());
    }
}
