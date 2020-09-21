<?php

use PHPUnit\Framework\TestCase;

class SiteValueTest extends TestCase
{
    public function testSiteValue()
    {
        $expect = 1234567;
        $site = new SiteValue($expect);
        $result = $site->getValue();

        $this->assertSame($expect, $result);
    }

    public function  testSiteValueTooShoortShouldThrowException()
    {
        $expect = 123;
        $this->expectException(ValueException::class);
        new SiteValue($expect);
    }

    public function  testSiteValueTooLongtShouldThrowException()
    {
        $expect = 123454678912343;
        $this->expectException(ValueException::class);
        new SiteValue($expect);
    }

    public function testToString() {
        $expect = 1234567;
        $site = new SiteValue($expect);
        $result = $site->toString();

        $this->assertSame("PBX_SITE=1234567", $result);
    }
}
