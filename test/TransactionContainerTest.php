<?php

require_once 'ETransaction/TransactionContainer.php';
require_once 'ETransaction/Devises.php';
require_once 'ETransaction/Values/CommandValue.php';
require_once 'ETransaction/Values/FeedbackValue.php';
require_once 'ETransaction/Values/HashValue.php';
require_once 'ETransaction/Values/HMACValue.php';
require_once 'ETransaction/Values/HolderValue.php';
require_once 'ETransaction/Values/IDValue.php';
require_once 'ETransaction/Values/RangValue.php';
require_once 'ETransaction/Values/SiteValue.php';
require_once 'ETransaction/Values/TimeValue.php';
require_once 'ETransaction/Values/TotalValue.php';
require_once 'ETransaction/Exceptions/TransactionContainerException.php';
require_once 'ETransaction/ParameterConstructor.php';


use PHPUnit\Framework\TestCase;

class TransactionContainerTest extends TestCase
{
    public function testFactoryRequiredData()
    {
        $total = 10.0;
        $rang = 7;
        $site = 1234567;
        $id = 123;
        $devise = Devises::EUR;
        $command = 'some-customer-id';
        $hash = 'SHA512';
        $hmac = '185f8db32271fe25f561a6fc938b2e264306ec304eda518007d1764826381969';
        $holder = 'this-is-me@somewhere.tld';
        $time = 1600424772;  // The date when the test was created
        $feedback = 'not';

        $transaction = TransactionContainer::fromData([
            'total' => $total,
            'rang' => $rang,
            'site' => $site,
            'id' => $id,
            'devise' => $devise,
            'command' => $command,
            'hash' => $hash,
            'hmac' => $hmac,
            'holder' => $holder,
            'time' => $time,
            'feedback' => $feedback,
        ]);

        $this->assertSame($transaction->getTotal()->getValue(), $total);
        $this->assertSame($transaction->getRang()->getValue(), $rang);
        $this->assertSame($transaction->getSite()->getValue(), $site);
        $this->assertSame($transaction->getId()->getValue(), $id);
        $this->assertSame($transaction->getDevise()->getValue(), $devise);
        $this->assertSame($transaction->getHash()->getValue(), $hash);
        $this->assertSame($transaction->getHMAC()->getValue(), $hmac);
        $this->assertSame($transaction->getHolder()->getValue(), $holder);
        $this->assertSame($transaction->getTime()->getValue(), $time);
        $this->assertSame($transaction->getFeedback()->getValue(), $feedback);
    }

    public function test_ensureRequiredKeysExists()
    {
        $transactionContainer = new TransactionContainer();
        try {
            $result = $transactionContainer->areRequiredKeysExist(
                ['total' => null, 'rang' => null, 'site' => null, 'id' => null,
                    'devise' => null, 'command' => null, 'hash' => null, 'hmac' => null,
                    'holder' => null, 'time' => null, 'feedback' => null]);
            $this->assertTrue($result);
        } catch (TransactionContainerException $e) {
            $this->fail("Exception shouldn't be raised");
        }
    }

    public function testMissingRequiredKeyTotalShouldRaiseAnException()
    {
        $this->expectException(TransactionContainerException::class);
        TransactionContainer::fromData(['rang' => null, 'site' => null, 'id' => null,
            'devise' => null, 'command' => null, 'hash' => null, 'hmac' => null,
            'holder' => null, 'time' => null, 'feedback' => null]);
    }

    public function testMissingRequiredKeyRangShouldRaiseAnException()
    {
        $this->expectException(TransactionContainerException::class);
        TransactionContainer::fromData(['total' => null, 'site' => null, 'id' => null,
            'devise' => null, 'command' => null, 'hash' => null, 'hmac' => null,
            'holder' => null, 'time' => null, 'feedback' => null]);
    }

    public function testMissingRequiredKeySiteShouldRaiseAnException()
    {
        $this->expectException(TransactionContainerException::class);
        TransactionContainer::fromData(['total' => null, 'rang' => null, 'id' => null,
            'devise' => null, 'command' => null, 'hash' => null, 'hmac' => null,
            'holder' => null, 'time' => null, 'feedback' => null]);
    }

    public function testMissingRequiredKeyIDShouldRaiseAnException()
    {
        $this->expectException(TransactionContainerException::class);
        TransactionContainer::fromData(['total' => null, 'rang' => null, 'site' => null,
            'devise' => null, 'command' => null, 'hash' => null, 'hmac' => null,
            'holder' => null, 'time' => null, 'feedback' => null]);
    }

    public function testMissingRequiredKeyDeviseShouldRaiseAnException()
    {
        $this->expectException(TransactionContainerException::class);
        TransactionContainer::fromData(['total' => null, 'rang' => null, 'site' => null, 'id' => null,
            'command' => null, 'hash' => null, 'hmac' => null,
            'holder' => null, 'time' => null, 'feedback' => null]);
    }

    public function testMissingRequiredKeyCommandShouldRaiseAnException()
    {
        $this->expectException(TransactionContainerException::class);
        TransactionContainer::fromData(['total' => null, 'rang' => null, 'site' => null, 'id' => null,
            'devise' => null, 'hash' => null, 'hmac' => null,
            'holder' => null, 'time' => null, 'feedback' => null]);
    }

    public function testMissingRequiredKeyHashShouldRaiseAnException()
    {
        $this->expectException(TransactionContainerException::class);
        TransactionContainer::fromData(['total' => null, 'rang' => null, 'site' => null, 'id' => null,
            'devise' => null, 'command' => null, 'hmac' => null,
            'holder' => null, 'time' => null, 'feedback' => null]);
    }

    public function testMissingRequiredKeyHMACShouldRaiseAnException()
    {
        $this->expectException(TransactionContainerException::class);
        TransactionContainer::fromData(['total' => null, 'rang' => null, 'site' => null, 'id' => null,
            'devise' => null, 'command' => null, 'hash' => null,
            'holder' => null, 'time' => null, 'feedback' => null]);
    }

    public function testMissingRequiredKeyPorteurShouldRaiseAnException()
    {
        $this->expectException(TransactionContainerException::class);
        TransactionContainer::fromData(['total' => null, 'rang' => null, 'site' => null, 'id' => null,
            'devise' => null, 'command' => null, 'hash' => null, 'hmac' => null,
            'time' => null, 'feedback' => null]);
    }

    public function testMissingRequiredKeyTimeShouldRaiseAnException()
    {
        $this->expectException(TransactionContainerException::class);
        TransactionContainer::fromData(['total' => null, 'rang' => null, 'site' => null, 'id' => null,
            'devise' => null, 'command' => null, 'hash' => null, 'hmac' => null,
            'holder' => null, 'feedback' => null]);
    }

    public function testMissingRequiredKeyURLBackShouldRaiseAnException()
    {
        $this->expectException(TransactionContainerException::class);
        TransactionContainer::fromData(['total' => null, 'rang' => null, 'site' => null, 'id' => null,
            'devise' => null, 'command' => null, 'hash' => null, 'hmac' => null,
            'holder' => null, 'time' => null]);
    }

    public function testSetTotal()
    {
        $expected = new TotalValue(10);
        $transac = new TransactionContainer();
        $transac->setTotal($expected);
        $this->assertSame($transac->getTotal()->getValue(), $expected->getValue());
    }

    public function testSetSite()
    {
        $expected = new SiteValue(1234567);
        $transac = new TransactionContainer();
        $transac->setSite($expected);
        $result = $transac->getSite()->getValue();

        $this->assertSame($expected->getValue(), $result);
    }

    public function testSetRang()
    {
        $expected = new RangValue('02');
        $transac = new TransactionContainer();
        $transac->setRang($expected);
        $result = $transac->getRang()->getValue();

        $this->assertSame($expected->getValue(), $result);
    }

    public function testSetId()
    {
        $expected = new IDValue(123);
        $transac = new TransactionContainer();
        $transac->setId($expected);
        $result = $transac->getId()->getValue();

        $this->assertSame($expected->getValue(), $result);
    }

    public function testSetDevise()
    {
        $expected = new RangValue('02');
        $transac = new TransactionContainer();
        $transac->setRang($expected);
        $result = $transac->getRang()->getValue();

        $this->assertSame($expected->getValue(), $result);
    }

    public function testSetCommand()
    {
        $expected = new CommandValue('some-id');
        $transac = new TransactionContainer();
        $transac->setCommand($expected);
        $result = $transac->getCommand()->getValue();

        $this->assertSame($expected->getValue(), $result);
    }

    public function testSetHash()
    {
        $expected = new HashValue(HashValue::SHA256);
        $transac = new TransactionContainer();
        $transac->setHash($expected);
        $result = $transac->getHash()->getValue();

        $this->assertSame($expected->getValue(), $result);
    }

    public function testSetHMAC()
    {
        $expected = new HMacValue('Bach music is into space');
        $transac = new TransactionContainer();
        $transac->setHMAC($expected);
        $result = $transac->getHMAC()->getValue();

        $this->assertSame($expected->getValue(), $result);

    }

    public function testSetHolder()
    {
        $expected = new HolderValue('bach@into-space.com');
        $transac = new TransactionContainer();
        $transac->setHolder($expected);
        $result = $transac->getHolder()->getValue();

        $this->assertSame($expected->getValue(), $result);

    }

    public function testSetTime()
    {
        $expected = new TimeValue(1);
        $transac = new TransactionContainer();
        $transac->setTime($expected);
        $result = $transac->getTime()->getValue();

        $this->assertSame($expected->getValue(), $result);
    }

    public function testSetFeedback()
    {
        $expected = new FeedbackValue('Mt:M;Ref:R;Auto:A;Erreur:E');
        $transac = new TransactionContainer();
        $transac->setFeedback($expected);
        $result = $transac->getFeedback()->getValue();

        $this->assertSame($expected->getValue(), $result);
    }

    public function testToString()
    {
        $total = 10.0;
        $rang = 7;
        $site = 1234567;
        $id = 123;
        $devise = Devises::EUR;
        $command = 'some-customer-id';
        $hash = HashValue::SHA512;
        $hmac = '185f8db32271fe25f561a6fc938b2e264306ec304eda518007d1764826381969';
        $holder = 'this-is-me@somewhere.tld';
        $time = 1600424772;  // The date when the test was created
        $feedback = 'not';

        $transaction = TransactionContainer::fromData([
            'total' => $total,
            'rang' => $rang,
            'site' => $site,
            'id' => $id,
            'devise' => $devise,
            'command' => $command,
            'hash' => $hash,
            'hmac' => $hmac,
            'holder' => $holder,
            'time' => $time,
            'feedback' => $feedback,
        ]);
        $result = $transaction->toString();
        $rang = sprintf("%'.03d", $rang);

        $this->assertSame("PBX_SITE=$site" .
            "&PBX_RANG=$rang" .
            "&PBX_IDENTIFIANT=$id" .
            "&PBX_DEVISE=$devise" .
            "&PBX_CMD=$command" .
            "&PBX_RETOUR=$feedback" .
            "&PBX_PORTEUR=$holder" .
            "&PBX_TOTAL=$total" .
            "&PBX_HASH=$hash" .
            "&PBX_HMAC=$hmac",
            $result);
    }

    public function testToStringForHashComputation()
    {
        $total = 10.0;
        $rang = 7;
        $site = 1234567;
        $id = 123;
        $devise = Devises::EUR;
        $command = 'some-customer-id';
        $hash = HashValue::SHA512;
        $hmac = '185f8db32271fe25f561a6fc938b2e264306ec304eda518007d1764826381969';
        $holder = 'this-is-me@somewhere.tld';
        $time = 1600424772;  // The date when the test was created
        $feedback = 'not';

        $transaction = TransactionContainer::fromData([
            'total' => $total,
            'rang' => $rang,
            'site' => $site,
            'id' => $id,
            'devise' => $devise,
            'command' => $command,
            'hash' => $hash,
            'hmac' => $hmac,
            'holder' => $holder,
            'time' => $time,
            'feedback' => $feedback,
        ]);

        $result = $transaction->toString(TransactionContainer::WithoutHMAC);
        $rang = sprintf("%'.03d", $rang);

        $this->assertSame("PBX_SITE=$site" .
            "&PBX_RANG=$rang" .
            "&PBX_IDENTIFIANT=$id" .
            "&PBX_DEVISE=$devise" .
            "&PBX_CMD=$command" .
            "&PBX_RETOUR=$feedback" .
            "&PBX_PORTEUR=$holder" .
            "&PBX_TOTAL=$total" .
            "&PBX_HASH=$hash",
            $result);

    }
}
