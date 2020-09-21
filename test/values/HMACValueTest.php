<?php

use PHPUnit\Framework\TestCase;


class HMACValueTest extends TestCase
{
    public function testHMACValue()
    {
        $value = "hello";
        $hmacValue = new HMACValue($value);
        $this->assertSame($hmacValue->getValue(), $value);
    }

    public function testToString()
    {
        $value = "hellloworld";
        $hmacValue = new HMACValue($value);
        $this->assertSame($hmacValue->toString(), "PBX_HMAC=$value");
    }

    public function testBinarize()
    {
        $value = 'helloworld';
        $expected = pack("H*", hexdec($value));

        $hmac = new HMACValue(hexdec($value));   // Not sure
        $this->assertSame($expected, $hmac->binarize());
    }
}