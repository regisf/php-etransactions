<?php

require_once 'ETransactions/Values/UrlValue.php';

use PHPUnit\Framework\TestCase;

class UrlValueTest extends TestCase
{
    public function testUrlValue()
    {
        $value = 'https://hello.com/address';
        $urlValue = new UrlValue($value, UrlType::Done);

        $this->assertSame($value, $urlValue->getValue());
    }

    public function testUrlValueDone() {
        $value = 'https://hello.com/address';
        $urlValue = new UrlValue($value, UrlType::Done);

        $this->assertSame("PBX_EFFECTUE=$value", $urlValue->toString());
    }

    public function testUrlValueCancel() {
        $value = 'https://hello.com/address';
        $urlValue = new UrlValue($value, UrlType::Canceled);

        $this->assertSame("PBX_ANNULE=$value", $urlValue->toString());
    }

    public function testUrlValueDenied() {
        $value = 'https://hello.com/address';
        $urlValue = new UrlValue($value, UrlType::Denied);

        $this->assertSame("PBX_REFUSE=$value", $urlValue->toString());
    }
}