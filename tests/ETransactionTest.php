<?php

require_once "ETransactions/ETransaction.php";

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

    public function testSetTransaction()
    {
        $data = TransactionData::fromData([
            'total' => 10.0,
            'rang' => 7,
            'site' => 1234567,
            'id' => 123,
            'devise' => Devises::EUR,
            'command' => 'some-customer-id',
            'hash' => HashValue::SHA512,
            'holder' => 'this-is-me@somewhere.tld',
            'time' => 1600424772,
            'feedback' => 'Mt:M',
            'secret' => '012456789abcdef'
        ]);

        $transac = new ETransaction(true);
        $transac->setTransactionData($data);

        $this->assertEquals($transac->getTransactionData(), $data);
    }

    public function testSetTransactionDataWithoutValidData()
    {
        $data = new TransactionData();
        $transac = new ETransaction(true);
        $this->expectException(ETransactionException::class);
        $transac->setTransactionData($data);
    }

    public function testGetServerKeyPreprod()
    {
        $transac = new ETransaction(true);
        $result = $transac->getServerKey();

        $this->assertEquals('preprod', $result);
    }

    public function testGetServerKeyProd()
    {
        $transac = new ETransaction();
        $result = $transac->getServerKey();

        $this->assertEquals('prod', $result);
    }

    public function testIsSandBox()
    {
        $transac = new ETransaction(true);
        $this->assertTrue($transac->isSandbox());
    }

    public function testIsntSandBox()
    {
        $transac = new ETransaction();
        $this->assertFalse($transac->isSandbox());
    }

    public function testGetTransactionForm()
    {
        $transaction = new ETransaction(true);
        if ($transaction->pingRemote() === false) {
            die('nable to contact the remove server');
        }

        // Set transaction data
        $transactionData = TransactionData::fromData([
            'total' => 10.0,
            'rang' => 7,
            'site' => 1234567,
            'id' => 123,
            'devise' => Devises::EUR,
            'command' => 'some-customer-id',
            'hash' => HashValue::SHA512,
            'holder' => 'this-is-me@somewhere.tld',
            'time' => 1600424772,
            'feedback' => 'Mt:M',
            'secret' => '0123456789abcdef'
        ]);

        $transaction->setTransactionData($transactionData);
        $transaction->getTransactionForm();
    }

}
