<?php

require_once 'ValueBase.php';


class HMACValue extends ValueBase
{
    protected $name = __CLASS__;
    protected $fieldName = 'PBX_HMAC';

    public function binarize()
    {
        return pack("H*", $this->getValue());
    }
}
