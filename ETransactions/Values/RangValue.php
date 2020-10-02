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


class RangValue extends ValueBase
{
    protected $name = __CLASS__;
    protected $fieldName = 'PBX_RANG';

    public function isValueRegular($value)
    {
        $v = (int)$value;
        if ($v > 0 && $v < 999) {
            return false;
        }

        return 'The rang value  must a 3 digit number';
    }

    public function getValue()
    {
        return sprintf("%'.03d", parent::getValue());
    }
}
