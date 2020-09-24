<?php

require_once 'ETransactions/Exceptions/ValueException.php';
require_once 'ETransactions/Values/TotalValue.php';

use PHPUnit\Framework\TestCase;

class TotalValueTest extends TestCase
{
    public function test__construct()
    {
        $expected = rand(1, 10);
        $value = new TotalValue($expected);
        $result = $value->getValue();
        $this->assertSame($result, $expected);
    }

    public function test__constructWithNegativeValueShouldThrowAnException()
    {
        $expected = rand(-10, -1);
        $this->expectException(ValueException::class);
        $value = new TotalValue($expected);
        $result = $value->getValue();
        $this->assertSame($result, $expected);
    }

    public function test__constructWithZeroValueShouldThrowAnException()
    {
        $expected = 0;
        $this->expectException(ValueException::class);
        $value = new TotalValue($expected);
        $result = $value->getValue();
        $this->assertSame($result, $expected);
    }

    public function testToString()
    {
        $expected = 123.45;
        $value = new TotalValue($expected);
        $result = $value->toString();
        $this->assertSame($result, "PBX_TOTAL=$expected");
    }

    public function testIsValueRegularAnythingButIntegerOrDouble()
    {
        $this->expectException(ValueException::class);
        new TotalValue("hello");

    }
}
