<?php
require_once 'ValueBase.php';

class HashValue extends ValueBase
{
    const SHA224 = 'SHA224';
    const SHA256 = 'SHA256';
    const SHA384 = 'SHA384';
    const SHA512 = 'SHA512';
    const RIPEMD160 = 'RIPEMD160';
    const MDC2 = 'MDC2';

    protected $name = __CLASS__;
    protected $fieldName = 'PBX_HASH';

    private $hashAlgorithm = array(
        HashValue::SHA224,
        HashValue::SHA256,
        HashValue::SHA384,
        HashValue::SHA512,
        HashValue::RIPEMD160,
        HashValue::MDC2
    );

    /**
     * HashValue constructor with default value as SHA512 as described into the documentation
     * @param string $value The Hash algorithm
     * @throws ValueException
     */
    public function __construct($value = HashValue::SHA512)
    {
        parent::__construct($value);
    }

    public function isValueRegular($value)
    {
        if (array_search($value, $this->hashAlgorithm, true) === false) {
            return 'Unknown algorithm ' . $value . '.';
        }

        return false;
    }

}
