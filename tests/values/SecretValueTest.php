<?php

require_once 'ETransactions/Values/SecretValue.php';

use PHPUnit\Framework\TestCase;

class SecretValueTest extends TestCase
{
    public function testClassName()
    {
        $secret = new SecretValue('il était un petit navire');
        $this->assertSame($secret->getName(), 'SecretValue');
    }
}