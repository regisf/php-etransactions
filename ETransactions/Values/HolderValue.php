<?php

require_once 'ValueBase.php';


class HolderValue extends ValueBase
{
    protected $name = __CLASS__;
    protected $fieldName = 'PBX_PORTEUR';

    public function isValueRegular($value)
    {
        if (filter_var($value, FILTER_VALIDATE_EMAIL)) {
            return false;
        }

        return "The email = '$value' isn't a valid one";
    }
}