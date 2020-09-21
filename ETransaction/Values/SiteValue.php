<?php

require_once 'ValueBase.php';


class SiteValue extends ValueBase
{
    protected $name = __CLASS__;

    public function isValueRegular($value)
    {
        $v = (int)$value;
        if (strlen("$v") === 7) {
            return false;
        }

        return 'The site value must be a seven digit number';
    }

    public function toString()
    {
        return 'PBX_SITE=' . $this->getValue();
    }
}
