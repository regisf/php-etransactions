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

require_once 'ValueBase.php';

class IDValue extends ValueBase
{
    protected $name = __CLASS__;
    protected $fieldName = 'PBX_IDENTIFIANT';

    public function isValueRegular($value)
    {
        $len = strlen("$value");
        if ($len > 0 && $len < 10) {
            return false;
        }

        return 'The id doesn\'t match the minimal requirements (1 to 9 digits)';
    }
}
