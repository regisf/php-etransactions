<?php
/*
 * ETransactions - Wrapper for e-transactions.fr service.
 * Copyright (C) 2020 Regis FLORET
 *
 * This library is free software; you can redistribute it and/or
 * modify it under the terms of the GNU Lesser General Public
 * License as published by the Free Software Foundation; either
 * version 2.1 of the License, or (at your option) any later version.
 *
 * This library is distributed in the hope that it will be useful,
 * but WITHOUT ANY WARRANTY; without even the implied warranty of
 * MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the GNU
 * Lesser General Public License for more details.
 *
 * You should have received a copy of the GNU Lesser General Public
 * License along with this library; if not, write to the Free Software
 * Foundation, Inc., 51 Franklin Street, Fifth Floor, Boston, MA  02110-1301  USA
 */

require_once 'ETransactions/Exceptions/TransactionDataException.php';
require_once 'ETransactions/ParameterConstructor.php';
require_once 'ETransactions/Values/CommandValue.php';
require_once 'ETransactions/Values/DeviseValue.php';
require_once 'ETransactions/Values/FeedbackValue.php';
require_once 'ETransactions/Values/HashValue.php';
require_once 'ETransactions/Values/HMACValue.php';
require_once 'ETransactions/Values/HolderValue.php';
require_once 'ETransactions/Values/IDValue.php';
require_once 'ETransactions/Values/RangValue.php';
require_once 'ETransactions/Values/SiteValue.php';
require_once 'ETransactions/Values/TimeValue.php';
require_once 'ETransactions/Values/TotalValue.php';
require_once 'ETransactions/TransactionDataIterator.php';

class TransactionData
{
    /**
     * @var TotalValue
     */
    public $total;

    /**
     * @var SiteValue
     */
    private $site;

    /**
     * @var RangValue
     */
    private $rang;

    /**
     * @var IDValue
     */
    private $id;

    /**
     * @var DeviseValue
     */
    private $devise;

    /**
     * @var CommandValue
     */
    private $command;

    /**
     * @var HashValue
     */
    private $hash;

    /**
     * @var HolderValue
     */
    private $holder;

    /**
     * @var TimeValue
     */
    private $param;

    /**
     * @var FeedbackValue
     */
    private $feedback;

    /**
     * @var SecretValue
     */
    private $secretKey;

    /**
     * Factory : create a container from data.
     *
     * @param $data array
     * @return TransactionData
     * @throws TransactionDataException|ValueException
     */
    public static function fromData(array $data)
    {
        $container = new TransactionData();

        if (gettype($data) === 'array') {
            $missingKeys = [];
            $result = $container->areRequiredKeysExist($data, $missingKeys);
            if ($result === false) {
                throw new TransactionDataException('Missing required keys: ' . join(', ', $missingKeys));
            }

            $container->setTotal(new TotalValue($data['total']));
            $container->setSite(new SiteValue($data['site']));
            $container->setId(new IDValue($data['id']));
            $container->setRang(new RangValue($data['rang']));
            $container->setCommand(new CommandValue($data['command']));
            $container->setHolder(new HolderValue($data['holder']));
            $container->setFeedback(new FeedbackValue($data['feedback']));
            $container->setSecret(new SecretValue($data['secret']));

            $time = isset($data['time']) ? $data['time'] : 0;
            $container->setTime(new TimeValue($time));

            $devise = isset($data['devise']) ? $data['devise'] : Devises::EUR;
            $container->setDevise(new DeviseValue($devise));

            $hash = isset($data['hash']) ? $data['hash'] : HashValue::SHA512;
            $container->setHash(new HashValue($hash));
        }

        return $container;
    }

    public function areRequiredKeysExist(array $data, array &$missingKeys = [])
    {
        $requiredKey = ['total', 'rang', 'site', 'id', 'command', 'holder', 'feedback', 'secret'];

        foreach ($requiredKey as $required) {
            if (!array_key_exists($required, $data)) {
                array_push($missingKeys, $required);
            }
        }

        return sizeof($missingKeys) === 0;
    }

    public function setTime(TimeValue $param)
    {
        $this->param = $param;
    }

    public function getTime()
    {
        return $this->param;
    }

    /**
     * Create a iterator object with all private fields
     * @return TransactionDataIterator The field iterator
     */
    public function getIterator()
    {
        return new TransactionDataIterator([
            $this->getSite(),
            $this->getRang(),
            $this->getId(),
            $this->getDevise(),
            $this->getCommand(),
            $this->getFeedback(),
            $this->getHolder(),
            $this->getTotal(),
            $this->getHash()
        ]);
    }

    public function getSite()
    {
        return $this->site;
    }

    public function setSite(SiteValue $site)
    {
        $this->site = $site;
    }

    public function getRang()
    {
        return $this->rang;
    }

    public function setRang(RangValue $rang)
    {
        $this->rang = $rang;
    }

    public function getId()
    {
        return $this->id;
    }

    public function setId(IDValue $id)
    {
        $this->id = $id;
    }

    public function getDevise()
    {
        return $this->devise;
    }

    public function setDevise(DeviseValue $devise)
    {
        $this->devise = $devise;
    }

    public function getCommand()
    {
        return $this->command;
    }

    public function setCommand(CommandValue $cmd)
    {
        $this->command = $cmd;
    }

    public function getFeedback()
    {
        return $this->feedback;
    }

    public function setFeedback(FeedbackValue $feedback)
    {
        $this->feedback = $feedback;
    }

    public function getHolder()
    {
        return $this->holder;
    }

    public function setHolder(HolderValue $holder)
    {
        $this->holder = $holder;
    }

    public function getTotal()
    {
        return $this->total;
    }

    public function setTotal(TotalValue $total)
    {
        $this->total = $total;
    }

    public function getHash()
    {
        return $this->hash;
    }

    public function setHash(HashValue $hash)
    {
        $this->hash = $hash;
    }

    /**
     * @param SecretValue $secretKey
     */
    public function setSecret($secretKey)
    {
        $this->secretKey = $secretKey;
    }

    /**
     * @return SecretValue The secret key for the transaction
     */
    public function getSecret()
    {
        return $this->secretKey;
    }

    /**
     * Test is all required fields are instanced.The value objects can't be created with wrong values
     *
     * @return bool True if all required values exists.
     */
    public function isValid()
    {
        return
            $this->getSite() !== null &&
            $this->getRang() !== null &&
            $this->getId() !== null &&
            $this->getDevise() !== null &&
            $this->getCommand() !== null &&
            $this->getFeedback() !== null &&
            $this->getHolder() !== null &&
            $this->getTotal() !== null &&
            $this->getHash() !== null;
    }

    public function toString()
    {
        $fields = $this->getFilledFields();
        return implode('&', $fields);
    }

    /**
     * Get all fields serialized. They must be always in the same order.
     *
     * @return array All filled serialized as a string
     */
    private function getFilledFields()
    {
        $parameterConstructor = new ParameterConstructor($this);
        return $parameterConstructor->asArray();
    }

    /**
     * Create a form field with hidden input. The order is important.
     * HMAC field is computed at this moment.
     *
     * @return string The HTML form content
     * @throws ValueException When HMAC is not valid.
     */
    public function toForm()
    {
        $hmacValue = new HMACValue($this->getSecret(), $this->toString(), $this->getHash());

        return $this->getSite()->toForm() .
            $this->getRang()->toForm() .
            $this->getId()->toForm() .
            $this->getDevise()->toForm() .
            $this->getCommand()->toForm() .
            $this->getFeedback()->toForm() .
            $this->getHolder()->toForm() .
            $this->getTotal()->toForm() .
            $this->getHash()->toForm() .
            $hmacValue->toForm();
    }
}
