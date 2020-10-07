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

require_once __DIR__ . '/ValueBase.php';


class TotalValue extends ValueBase
{
    protected $name = __CLASS__;
    protected $fieldName = 'PBX_TOTAL';

    public function isValueRegular($value)
    {
        $type = gettype($value);
        if (!($type === 'double' || $type === 'integer')) {
            return "Wrong initializer type. Got  $type";
        }

        if ($value <= 0) {
            return "Value can't be negatif. Value = $value";
        }

        return false;
    }

    public function getValue()
    {
        return parent::getValue() * 100;
    }
}

