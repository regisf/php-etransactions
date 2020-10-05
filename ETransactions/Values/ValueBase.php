<?php
/*
 * ETransactions - Wrapper for e-transactions.fr service.
 * Copyright (C) 2020 Regis FLORET
 *
 * This library is free software; you can redistribute it and/or
 * modify it under the terms of the GNU Lesser General Public
 * License as published by the Free Software Foundation; either
 * version 2.1 of the License, or (at your option) any later version.
 *
 * This library is distributed in the hope that it will be useful,
 * but WITHOUT ANY WARRANTY; without even the implied warranty of
 * MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the GNU
 * Lesser General Public License for more details.
 *
 * You should have received a copy of the GNU Lesser General Public
 * License along with this library; if not, write to the Free Software
 * Foundation, Inc., 51 Franklin Street, Fifth Floor, Boston, MA  02110-1301  USA
 */

require __DIR__  . '/../Exceptions/ValueException.php';

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
        return '<input type="hidden" name="' . $this->fieldName . '" value="' . $this->getValue() . '" />';
    }

    public function toString()
    {
        return $this->getFieldName() . '=' . $this->getValue();
    }
}