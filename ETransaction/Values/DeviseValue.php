<?php

require_once 'ValueBase.php';

class DeviseValue extends ValueBase
{
    protected $name = __CLASS__;

    public function isValueRegular($value)
    {
        if ((int)$value === 978) {
            return false;
        }

        return 'Devise must be set as EURO';
    }

    public function toString()
    {
        return 'PBX_DEVISE=' . $this->getValue();
    }
}