<?php

abstract class ValueBase
{
    protected $name = __CLASS__;

    /**
     * @var string The HTML Field name. This property must be set into the derived class
     */
    protected $fieldName = null;

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

    public function getFieldName()
    {
        return $this->fieldName;
    }

    public function toForm()
    {
        return '<input type="hidden" name="' . $this->fieldName . '" value="' . $this->value . '" />';
    }

    public function toString()
    {
        return $this->getFieldName() . '=' . $this->getValue();
    }
}