<?php
/**
 * Created by enea dhack - 12/07/2020 11:47.
 */

namespace Vaened\Enum\Tests;

use BadMethodCallException;
use UnexpectedValueException;
use Vaened\Enum\Tests\Enumerables\Status;

class ValidationsTest extends TestCase
{
    public function test_creating_an_invalid_enum_throws_an_exception(): void
    {
        $this->expectException(UnexpectedValueException::class);
        $this->expectExceptionMessage("Value 'non-existent' is not part of the enum " . Status::class);
        Status::create('non-existent');
    }

    public function test_creating_an_enum_by_invalid_key_throws_an_exception(): void
    {
        $this->expectException(UnexpectedValueException::class);
        $this->expectExceptionMessage("Key 'non-existent' is not part of the enum " . Status::class);
        Status::instantiate('non-existent');
    }

    public function test_calling_dynamic_method_of_invalid_value_throws_exception(): void
    {
        $this->expectException(BadMethodCallException::class);
        $this->expectExceptionMessage("No static method or enum constant 'DANGER' in enum " . Status::class);
        forward_static_call([Status::class, 'DANGER']);
    }

    public function test_validate_enum_member_value(): void
    {
        $this->assertTrue(Status::isValid(Status::WARNING));
        $this->assertTrue(Status::isValid('Éxito'));
        $this->assertFalse(Status::isValid('non-existent'));
    }
}
