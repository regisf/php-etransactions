<?php

require_once 'ValueBase.php';


class HMACValue extends ValueBase
{
    protected $name = __CLASS__;
    protected $fieldName = 'PBX_HMAC';

    /**
     * Compute the HMAC value at the object creation
     *
     * @param $secretKey
     * @param string $parameters
     * @param HashValue $hashValue
     * @throws ValueException
     */
    public function __construct($secretKey, $parameters, $hashValue)
    {
        $binKey = pack('H*', $secretKey);
        $hash = strtoupper(hash_hmac($hashValue->getValue(), $parameters, $binKey));

        parent::__construct($hash);
    }
}
