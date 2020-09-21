<?php

use PHPUnit\Framework\TestCase;

class IDValueTest extends TestCase
{
    public function testCustomerIDValue()
    {
        $expected = 123;

        $result = (new IDValue($expected))->getValue();

        $this->assertSame($expected, $result);
    }

    public function testToString()
    {
        $value = 123;
        $result = (new IDValue($value))->toString();
        $this->assertSame($result, "PBX_IDENTIFIANT=$value");
    }
}