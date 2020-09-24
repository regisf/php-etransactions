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

    /**
     * @throws ETransactionException
     * @throws TransactionDataException
     * @throws ValueException
     */
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

    /**
     * @throws ETransactionException
     * @throws TransactionDataException
     * @throws ValueException
     */
    public function testGetTransactionFormHaveAHMACField()
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
        $form = $transaction->getTransactionForm();
        $this->assertMatchesRegularExpression('/\<input\s+type="hidden"\s+name="PBX_SITE"\s+value="1234567"\s*\/>/', $form);
        $this->assertMatchesRegularExpression('/\<input\s+type="hidden"\s+name="PBX_RANG"\s+value="7"\s*\/>/', $form);
        $this->assertMatchesRegularExpression('/\<input\s+type="hidden"\s+name="PBX_IDENTIFIANT"\s+value="123"\s*\/>/', $form);
        $this->assertMatchesRegularExpression('/\<input\s+type="hidden"\s+name="PBX_DEVISE"\s+value="978"\s*\/>/', $form);
        $this->assertMatchesRegularExpression('/\<input\s+type="hidden"\s+name="PBX_CMD"\s+value="some-\s*ustomer-id" \/>/', $form);
        $this->assertMatchesRegularExpression('/\<input\s+type="hidden"\s+name="PBX_RETOUR"\s+value="Mt:\s*" \/>/', $form);
        $this->assertMatchesRegularExpression('/\<input\s+type="hidden"\s+name="PBX_PORTEUR"\s+value="this-\s*s-me@somewhere.tld" \/>/', $form);
        $this->assertMatchesRegularExpression('/\<input\s+type="hidden"\s+name="PBX_TOTAL"\s+value="10"\s*\/>/', $form);
        $this->assertMatchesRegularExpression('/\<input\s+type="hidden"\s+name="PBX_HASH"\s+value="SHA512"\s*\/>/', $form);
        $this->assertMatchesRegularExpression('/\<input\s+type="hidden"\s+name="PBX_HMAC"\s+value="\w+"\s*\/>/', $form);
    }

}
