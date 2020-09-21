<?php

use PHPUnit\Framework\TestCase;

class RangValueTest extends TestCase
{
    public function testRangValue()
    {
        $expected = '02';
        $rang = new RangValue($expected);
        $result = $rang->getValue();
        $this->assertSame($result, $expected);
    }

    public function testRangValueWithValueTooBig()
    {
        $expected = '212';
        $this->expectException(ValueException::class);
        $rang = new RangValue($expected);
    }

    public function testToStringMustReturnsAString() {
        $expect = '002';
        $site = new RangValue($expect);
        $result = $site->toString();

        $this->assertSame("PBX_RANG=$expect", $result);
    }
}