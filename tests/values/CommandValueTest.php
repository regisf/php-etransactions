<?php

require_once 'ETransaction/Values/CommandValue.php';
require_once 'ETransaction/Exceptions/ValueException.php';

use PHPUnit\Framework\TestCase;

class CommandValueTest extends TestCase
{
    public function testCommandValue() {
        $expected = 'some-id-for-customer-command';
        $cmdValue = new CommandValue($expected);
        $this->assertSame($cmdValue->getValue(), $expected);
    }

    public function testCommandValueWithNullValue() {
        $this->expectException(ValueException::class);
        new CommandValue(null);
    }

    public function testCommandValueWithEmptyValue() {
        $this->expectException(ValueException::class);
        new CommandValue('');
    }

    public function testToString() {
        $value = 'some-customer-id';

        $cmdValue = new CommandValue($value);
        $result = $cmdValue->toString();
        $this->assertSame($result, "PBX_CMD=$value");
    }
}
