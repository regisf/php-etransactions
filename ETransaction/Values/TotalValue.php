<?php

require_once 'ValueBase.php';


class TotalValue extends ValueBase
{
    protected $name = __CLASS__;

    public function toString()
    {
        return 'PBX_TOTAL=' . $this->getValue();
    }

    public function isValueRegular($value)
    {
        $type = gettype($value);
        if (!($type === 'double' || $type === 'integer')) {
            return "Wrong initializer type. Got  $type";
        }

        if ($value <= 0) {
            return "Value can't be negatif. Value = $value";
        }

        return false;
    }
}

