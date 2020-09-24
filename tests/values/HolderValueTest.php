<?php

use PHPUnit\Framework\TestCase;

class HolderValueTest extends TestCase
{
    public function testHolderValue()
    {
        $email = 'valid.user@somewhere.com';

        $HolderValue = new HolderValue($email);
        $this->assertSame($HolderValue->getValue(), $email);
    }

    public function testHolderValueWithInvalidEmail()
    {
        $email = 'invalid-user';

        $this->expectException(ValueException::class);
        new HolderValue($email);
    }

    public function testToString() {
        $email = 'valid.user@somewhere.com';

        $HolderValue = new HolderValue($email);
        $this->assertSame($HolderValue->toString(), "PBX_PORTEUR=$email");

    }
}