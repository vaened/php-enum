<?php
/**
 * Created by enea dhack - 08/07/2020 17:38.
 */

namespace Vaened\Enum\Tests;

use Vaened\Enum\Tests\Enumerables\Status;

class EnumTest extends TestCase
{
    public function test_create_a_valid_enum(): void
    {
        $this->assertEquals(Status::WARNING, Status::create(Status::WARNING)->value());
        $this->assertEquals('SUCCESS', Status::create(Status::SUCCESS)->key());
    }

    public function test_create_a_valid_enum_from_key(): void
    {
        $this->assertEquals('WARNING', Status::instantiate('WARNING')->key());
        $this->assertEquals(Status::SUCCESS, Status::instantiate('SUCCESS')->value());
    }

    public function test_the_value_is_obtained_from_the_enumeration(): void
    {
        $this->assertEquals(Status::WARNING, Status::WARNING()->value());
        $this->assertEquals(Status::SUCCESS, Status::SUCCESS()->value());
    }

    public function test_get_the_key_of_the_enum(): void
    {
        $this->assertEquals('WARNING', Status::WARNING()->key());
        $this->assertEquals('SUCCESS', Status::SUCCESS()->key());
    }

    public function test_call_dynamic_methods_enum(): void
    {
        $this->assertInstanceOf(Status::class, Status::WARNING());
        $this->assertInstanceOf(Status::class, Status::SUCCESS());
    }

    public function test_enumeration_is_converted_to_string(): void
    {
        $this->assertIsString(Status::WARNING, Status::WARNING()->__toString());
        $this->assertEquals(Status::SUCCESS, Status::SUCCESS()->__toString());
    }

    public function test_compare_equal_values(): void
    {
        $this->assertTrue(Status::WARNING()->equals('Advertencia'));
        $this->assertFalse(Status::WARNING()->equals('non-existent'));
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
