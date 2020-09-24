<?php

require_once 'ValueBase.php';

class CommandValue extends ValueBase
{
    protected $name = __CLASS__;
    protected $fieldName = 'PBX_CMD';

    public function isValueRegular($value)
    {
        if ($value) {
            return false;
        }
        return 'The command value must be at last something stringable not nothing';
    }

}