<?php

require_once 'ValueBase.php';

class DeviseValue extends ValueBase
{
    protected $name = __CLASS__;
    protected $fieldName = 'PBX_DEVISE';

    public function isValueRegular($value)
    {
        if ((int)$value === 978) {
            return false;
        }

        return 'Devise must be set as EURO';
    }
}