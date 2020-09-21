<?php

require_once 'ValueBase.php';



class IDValue extends ValueBase
{
    protected $name = __CLASS__;

    public function isValueRegular($value)
    {
        $len = strlen("$value");
        if ($len > 0 && $len < 10) {
            return false;
        }

        return 'The id doesn\'t match the minimal requirements (1 to 9 digits)';


    }

    public function toString()
    {
        return 'PBX_IDENTIFIANT=' . $this->getValue();
    }
}