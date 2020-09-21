<?php

require_once 'ValueBase.php';


class RangValue extends ValueBase
{
    protected $name = __CLASS__;

    public function isValueRegular($value)
    {
        $v = (int)$value;
        if ($v > 0 && $v < 100) {
            return false;
        }

        return 'The rang value  must a 3 digit number';
    }

    public function toString()
    {
        return sprintf("PBX_RANG=%'.03d", $this->getValue());
    }
}
