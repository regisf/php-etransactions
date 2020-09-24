<?php

require_once 'ETransactions/Devises.php';
require_once 'ETransactions/Values/DeviseValue.php';
require_once 'ETransactions/Exceptions/ValueException.php';

use PHPUnit\Framework\TestCase;

class DeviseValueTest extends TestCase
{
    public function testDeviseValue()
    {
        $value = new DeviseValue(Devises::EUR);
        $result = $value->getValue();
        $this->assertSame($result, Devises::EUR);
    }

    public function testDeviseValueEverythingElseButEuro() {
        $this->expectException(ValueException::class);
        $value = new DeviseValue(840); // ISO code for Dollar
    }

    public function testToString() {
        $value = new DeviseValue(Devises::EUR);
        $result = $value->toString();
        $this->assertSame(gettype($result), 'string');
        $this->assertSame($result, "PBX_DEVISE=978");
    }
}
