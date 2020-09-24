<?php

use PHPUnit\Framework\TestCase;

class HashValueTest extends TestCase
{
    public function testHashValue()
    {
        $expected = HashValue::SHA224;
        $hashValue = new HashValue($expected);
        $result = $hashValue->getValue();
        $this->assertSame($result, $expected);
    }

    public function testWithDefaultValue()
    {
        $expected = 'SHA512';
        $hashValue = new HashValue();
        $result = $hashValue->getValue();
        $this->assertSame($result, $expected);
    }

    public function testToString()
    {
        $expected = HashValue::SHA256;
        $hashValue = new HashValue($expected);
        $result = $hashValue->toString();

        $this->assertSame($result, "PBX_HASH=$expected");
    }

    public function testNotKnownAlgorithm()
    {
        $this->expectException(ValueException::class);
        $expected = 'SHA1';
        $hashValue = new HashValue($expected);
        $result = $hashValue->toString();

        $this->assertSame($result, "PBX_HASH=$expected");
    }
}