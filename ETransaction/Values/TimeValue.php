<?php

require_once 'ValueBase.php';


class TimeValue extends ValueBase
{
    protected $name = __CLASS__;

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

    public function toString()
    {
        return 'PBX_TIME=' . date('c', $this->getValue());
    }
}