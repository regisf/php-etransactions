<?php

require_once "ETransaction/ETransaction.php";

use PHPUnit\Framework\TestCase;

class ETransactionTest extends TestCase
{
    public function testETransactionConstructorSetTheSandboxFlagAsFalse()
    {
        $transac = new ETransaction();
        $this->assertFalse($transac->isSandbox());
    }

    public function testETransactionConstructorSetTheSandboxFlagAsTrue()
    {
        $transac = new ETransaction(true);
        $this->assertTrue($transac->isSandbox());
    }
}
