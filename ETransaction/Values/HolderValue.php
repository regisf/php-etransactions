<?php

require_once 'ValueBase.php';


class HolderValue extends ValueBase
{
    protected $name = __CLASS__;

    public function isValueRegular($value)
    {
        if (filter_var($value, FILTER_VALIDATE_EMAIL)) {
            return false;
        }

        return "The email = '$value' isn't a valid one";
    }

    public function toString()
    {
        return 'PBX_PORTEUR=' . $this->getValue();
    }
}