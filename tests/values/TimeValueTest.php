<?php

use PHPUnit\Framework\TestCase;

class TimeValueTest extends TestCase
{
    public function testIsValueRegular()
    {
        $timeValue = new TimeValue();

        // Testing with a regex because time() is unknown
        $this->assertMatchesRegularExpression('/^\d{4}-\d{2}-\d{2}T\d{2}:\d{2}:\d{2}\+\d{2}:\d{2}$/',
            $timeValue->getValue());
    }

    public function testToString()
    {
        $timeValue = new TimeValue(1); // 1 second after the Big Bang
        $this->assertSame($timeValue->toString(), "PBX_TIME=1970-01-01T00:00:01+00:00");
    }

    public function testIsValueRegularNotAStringThrowException()
    {
        $this->expectException(ValueException::class);
        new TimeValue('hello, world');
    }
}
