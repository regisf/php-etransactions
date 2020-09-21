<?php

use PHPUnit\Framework\TestCase;

class TimeValueTest extends TestCase
{
    public function testIsValueRegular()
    {
        $timeValue = new TimeValue();
        $this->assertSame(gettype($timeValue->getValue()), 'integer');
    }

    public function testToString()
    {
        $timeValue = new TimeValue(1); // 1 second after the Big Bang
        $this->assertSame($timeValue->toString(), "PBX_TIME=1970-01-01T00:00:01+00:00");
    }
}
