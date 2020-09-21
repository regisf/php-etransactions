<?php

require_once 'ValueBase.php';


class HMACValue extends ValueBase
{
    protected $name = __CLASS__;

    public function toString()
    {
        return 'PBX_HMAC=' . $this->getValue();
    }

    public function binarize()
    {
        return pack("H*", $this->getValue());
    }
}
