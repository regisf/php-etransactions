<?php

require_once __DIR__ . '/ValueBase.php';

class UUIDValue extends ValueBase
{
    public function isValueRegular($value)
    {
        if (preg_match('/^[0-9A-F]{8}-[0-9A-F]{4}-4[0-9A-F]{3}-[89AB][0-9A-F]{3}-[0-9A-F]{12}$/i', $value) === false)
        {
            return 'Not a valid UUID4';
        }

        return false;
    }
}