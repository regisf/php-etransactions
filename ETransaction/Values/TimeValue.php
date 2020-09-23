<?php

require_once 'ValueBase.php';


class TimeValue extends ValueBase
{
    protected $name = __CLASS__;
    protected $fieldName = 'PBX_TIME';

    /**
     * TimeValue constructor, allow no value.
     *
     * @param int $timestamp The
     * @throws ValueException
     */
    public function __construct($timestamp = 0)
    {
        parent::__construct($timestamp);

    }

    public function isValueRegular($value)
    {
        if (gettype($value) !== 'integer') {
            return 'The TimeValue object requires an integer as parameter';
        }

        if ($value === 0) {
            $timestamp = time();
        }

        return false;
    }

    public function getValue()
    {
        return date('c', parent::getValue());
    }
}