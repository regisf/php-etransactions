<?php

abstract class ValueBase
{
    protected $name = __CLASS__;
    private $value;

    public function __construct($value)
    {
        $result = $this->isValueRegular($value);
        if (gettype($result) === 'string') {
            throw new ValueException($result);
        }

        $this->value = $value;
    }

    public function isValueRegular($value)
    {
        return false;
    }

    public function getValue()
    {
        return $this->value;
    }

    public function getName()
    {
        return $this->name;
    }

    abstract public function toString();
}