<?php

require_once 'ValueBase.php';


class SiteValue extends ValueBase
{
    protected $name = __CLASS__;
    protected $fieldName = 'PBX_SITE';

    public function isValueRegular($value)
    {
        $v = (int)$value;
        if (strlen("$v") === 7) {
            return false;
        }

        return 'The site value must be a seven digit number';
    }
}
