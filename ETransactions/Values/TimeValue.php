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