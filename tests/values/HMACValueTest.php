<?php

use PHPUnit\Framework\TestCase;

const SECRET = '0123456789ABCDEF0123456789ABCDEF';

class HMACValueTest extends TestCase
{
    public function testHMACValue()
    {
        $hmacValue = new HMACValue(new SecretValue(SECRET), 'thisis=1&pra=2', new HashValue());
        $this->assertSame($hmacValue->getValue(), '459F6ABB6B8ACEFF85267AE80E52E480683536710E8DFA85890D43E4A9010305687737FF4DF60BAD7880BE44C60CDBB4C7C2F27BC82EE8135EBC40264F0AB9A4');
    }

    public function testToString()
    {
        $hmacValue = new HMACValue(new SecretValue(SECRET), 'thisis=1&pra=2', new HashValue());
        $this->assertSame($hmacValue->toString(), "PBX_HMAC=459F6ABB6B8ACEFF85267AE80E52E480683536710E8DFA85890D43E4A9010305687737FF4DF60BAD7880BE44C60CDBB4C7C2F27BC82EE8135EBC40264F0AB9A4");
    }
}