<?php
/**
 * Created by enea dhack - 08/07/2020 17:38.
 */

namespace Vaened\Enum\Tests;

use Vaened\Enum\Tests\Enumerables\Code;
use Vaened\Enum\Tests\Enumerables\PrimitiveEnum;
use Vaened\Enum\Tests\Enumerables\Status;

class EnumTest extends TestCase
{
    public function test_create_a_valid_enum(): void
    {
        $this->assertEquals(Status::WARNING, Status::create(Status::WARNING)->value());
        $this->assertEquals('SUCCESS', Status::create(Status::SUCCESS)->key());

        $this->assertEquals(Code::UNAUTHORIZED, Code::create(Code::UNAUTHORIZED)->value());
        $this->assertEquals('NOT_FOUND', Code::create(Code::NOT_FOUND)->key());
    }

    public function test_create_a_valid_enum_from_key(): void
    {
        $this->assertEquals('WARNING', Status::instantiate('WARNING')->key());
        $this->assertEquals(Status::SUCCESS, Status::instantiate('SUCCESS')->value());

        $this->assertEquals('UNAUTHORIZED', Code::instantiate('UNAUTHORIZED')->key());
        $this->assertEquals(Code::NOT_FOUND, Code::instantiate('NOT_FOUND')->value());
    }

    public function test_the_value_is_obtained_from_the_enumeration(): void
    {
        $this->assertEquals(Status::WARNING, Status::WARNING()->value());
        $this->assertEquals(Status::SUCCESS, Status::SUCCESS()->value());

        $this->assertEquals(Code::UNAUTHORIZED, Code::UNAUTHORIZED()->value());
        $this->assertEquals(Code::NOT_FOUND, Code::NOT_FOUND()->value());
    }

    public function test_get_the_key_of_the_enum(): void
    {
        $this->assertEquals('WARNING', Status::WARNING()->key());
        $this->assertEquals('SUCCESS', Status::SUCCESS()->key());

        $this->assertEquals('UNAUTHORIZED', Code::UNAUTHORIZED()->key());
        $this->assertEquals('NOT_FOUND', Code::NOT_FOUND()->key());
    }

    public function test_call_dynamic_methods_enum(): void
    {
        $this->assertInstanceOf(Status::class, Status::WARNING());
        $this->assertInstanceOf(Status::class, Status::SUCCESS());

        $this->assertInstanceOf(Code::class, Code::UNAUTHORIZED());
        $this->assertInstanceOf(Code::class, Code::NOT_FOUND());
    }

    public function test_enumeration_is_converted_to_string(): void
    {
        $this->assertIsString(Status::WARNING, Status::WARNING()->__toString());
        $this->assertEquals(Status::SUCCESS, Status::SUCCESS()->__toString());

        $this->assertIsString((string) Code::UNAUTHORIZED, Code::UNAUTHORIZED()->__toString());
        $this->assertEquals((string) Code::NOT_FOUND, Code::NOT_FOUND()->__toString());
    }

    public function test_compare_equal_values(): void
    {
        $this->assertTrue(Code::UNAUTHORIZED()->equals(403));
        $this->assertTrue(Status::WARNING()->equals('Advertencia'));
        $this->assertFalse(Status::WARNING()->equals('non-existent'));
    }

    public function test_compare_match_values(): void
    {
        $this->assertTrue(Code::UNAUTHORIZED()->match(Code::UNAUTHORIZED()));
        $this->assertTrue(Status::WARNING()->equals(Status::WARNING()));
        $this->assertFalse(Status::WARNING()->equals(Code::UNAUTHORIZED()));
    }

    public function test_enumeration_supports_primitive_values(): void
    {
        $this->assertTrue(PrimitiveEnum::BOOLEAN()->equals(true));
        $this->assertTrue(PrimitiveEnum::FLOAT()->equals(2.1));
        $this->assertTrue(PrimitiveEnum::INTEGER()->equals(1));
        $this->assertTrue(PrimitiveEnum::STRING()->equals('string'));
        $this->assertTrue(PrimitiveEnum::STRING()->equals(PrimitiveEnum::STRING()));
    }

    public function test_extract_the_values_of_an_enum(): void
    {
        $values = $this->getEnumValues();
        $enum = Status::values();

        $this->assertCount(count($values), $enum);
        foreach ($values as $key => $value) {
            $this->assertArrayHasKey($key, $enum);
            $this->assertInstanceOf(Status::class, $enum[$key]);
            $this->assertEquals($value['value'], $enum[$key]->value());
            $this->assertEquals($key, $enum[$key]->key());
        }
    }

    private function getEnumValues(): array
    {
        return [
            'WARNING' => [
                'value' => 'Advertencia',
            ],
            'SUCCESS' => [
                'value' => 'Éxito',
            ],
        ];
    }
}
