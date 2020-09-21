<?php

require_once 'ETransaction/Exceptions/TransactionContainerException.php';
require_once 'ETransaction/ParameterConstructor.php';
require_once 'ETransaction/Values/CommandValue.php';
require_once 'ETransaction/Values/DeviseValue.php';
require_once 'ETransaction/Values/FeedbackValue.php';
require_once 'ETransaction/Values/HashValue.php';
require_once 'ETransaction/Values/HMACValue.php';
require_once 'ETransaction/Values/HolderValue.php';
require_once 'ETransaction/Values/IDValue.php';
require_once 'ETransaction/Values/RangValue.php';
require_once 'ETransaction/Values/SiteValue.php';
require_once 'ETransaction/Values/TimeValue.php';
require_once 'ETransaction/Values/TotalValue.php';


class TransactionContainer
{
    /* Declare boolean constants for expressiveness */
    const WithoutHMAC = true;
    const WithHMAC = false;

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
     * @var  HMacValue
     */
    private $hmac;

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
     * Factory : create a container from data.
     *
     * @param $data array
     * @return TransactionContainer
     * @throws TransactionContainerException|\ETransaction\Values\ValueException
     */
    public static function fromData(array $data)
    {
        $container = new TransactionContainer();

        if (gettype($data) === 'array') {
            $missingKeys = [];
            $result = $container->areRequiredKeysExist($data, $missingKeys);
            if ($result === false) {
                throw new TransactionContainerException('Missing required keys: ' . join(', ', $missingKeys));
            }

            $container->setTotal(new TotalValue($data['total']));
            $container->setSite(new SiteValue($data['site']));
            $container->setId(new IDValue($data['id']));
            $container->setRang(new RangValue($data['rang']));
            $container->setDevise(new DeviseValue($data['devise']));
            $container->setCommand(new CommandValue($data['command']));
            $container->setHash(new HashValue($data['hash']));
            $container->setHMAC(new HMACValue($data['hmac']));
            $container->setHolder(new HolderValue($data['holder']));
            $container->setTime(new TimeValue($data['time']));
            $container->setFeedback(new FeedbackValue($data['feedback']));
        }

        return $container;
    }

    public function areRequiredKeysExist(array $data, array &$missingKeys = [])
    {
        $requiredKey = ['total', 'rang', 'site', 'id', 'devise', 'command', 'hash', 'hmac', 'holder', 'time', 'feedback'];

        foreach ($requiredKey as $required) {
            if (!array_key_exists($required, $data)) {
                array_push($missingKeys, $required);
            }
        }

        return sizeof($missingKeys) === 0;
    }

    /**
     * Get all fields serialized. They must be always in the same order.
     *
     * @param bool $withoutHMAC A boolean parameter
     * @return array All filled serialized as a string
     */
    private function getFilledFields($withoutHMAC)
    {
        $parameterConstructor = new ParameterConstructor($this, $withoutHMAC);
        return $parameterConstructor->asArray();
    }

    /**
     * Encode all fields send as parameters.
     */
    private function encodeParameters()
    {
        $params = $this->getFilledFields(TransactionContainer::WithoutHMAC);
        $binarizedSecretKey = $this->getHMAC()->binarize();

    }

    public function toString($withoutHMAC = TransactionContainer::WithHMAC)
    {
        $fields = $this->getFilledFields($withoutHMAC);
        return implode('&', $fields);
    }

    public function setTotal(TotalValue $total)
    {
        $this->total = $total;
    }

    public function getTotal()
    {
        return $this->total;
    }

    public function setSite(SiteValue $site)
    {
        $this->site = $site;
    }

    public function getSite()
    {
        return $this->site;
    }

    public function setRang(RangValue $rang)
    {
        $this->rang = $rang;
    }

    public function getRang()
    {
        return $this->rang;
    }

    public function setId(IDValue $id)
    {
        $this->id = $id;
    }

    public function getId()
    {
        return $this->id;
    }

    public function setDevise(DeviseValue $devise)
    {
        $this->devise = $devise;
    }

    public function getDevise()
    {
        return $this->devise;
    }

    public function setCommand(CommandValue $cmd)
    {
        $this->command = $cmd;
    }

    public function getCommand()
    {
        return $this->command;
    }

    public function setHash(HashValue $hash)
    {
        $this->hash = $hash;
    }

    public function getHash()
    {
        return $this->hash;
    }

    public function setHMAC(HMacValue $hmac)
    {
        $this->hmac = $hmac;
    }

    public function getHMAC()
    {
        return $this->hmac;
    }

    public function setHolder(HolderValue $holder)
    {
        $this->holder = $holder;
    }

    public function getHolder()
    {
        return $this->holder;
    }

    public function setTime(TimeValue $param)
    {
        $this->param = $param;
    }

    public function getTime()
    {
        return $this->param;
    }

    public function setFeedback(FeedbackValue $feedback)
    {
        $this->feedback = $feedback;
    }

    public function getFeedback()
    {
        return $this->feedback;
    }

    /**
     * Create a iterator object with all private fields
     * @return TransactionContainerIterator The field iterator
     */
    public function getIterator()
    {
        return new TransactionContainerIterator([
            $this->getSite(),
            $this->getRang(),
            $this->getId(),
            $this->getDevise(),
            $this->getCommand(),
            $this->getFeedback(),
            $this->getHolder(),
            $this->getTotal(),
            $this->getHash(),
            $this->getHMAC(),
        ]);
    }
}
