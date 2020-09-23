<?php

require_once 'ValueBase.php';


class TimeValue extends ValueBase
{
    protected $name = __CLASS__;
    protected $fieldName = 'PBX_TIME';

    /**
     * TimeValue constructor. If no timestamp is given, the current timestamp is set using the 'time()' function.
     *
     * @param int $timestamp The timestamp for the transaction
     * @throws ValueException
     * @see time
     */
    public function __construct($timestamp = 0)
    {
        if ($timestamp === 0) {
            $timestamp = time();
        }

        parent::__construct($timestamp);
    }

    public function isValueRegular($value)
    {
        if (gettype($value) !== 'integer') {
            return 'The TimeValue object requires an integer as parameter';
        }

        return false;
    }

    public function getValue()
    {
        return date('c', parent::getValue());
    }
}