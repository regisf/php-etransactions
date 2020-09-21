<?php

require_once 'ValueBase.php';

class CommandValue extends ValueBase
{
    protected $name = __CLASS__;

    public function isValueRegular($value)
    {
        if ($value) {
            return false;
        }
        return 'The command value must be at last something stringable not nothing';
    }

    public function toString()
    {
        return 'PBX_CMD=' . $this->getValue();
    }
}