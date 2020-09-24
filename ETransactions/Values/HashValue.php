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

class HashValue extends ValueBase
{
    const SHA224 = 'SHA224';
    const SHA256 = 'SHA256';
    const SHA384 = 'SHA384';
    const SHA512 = 'SHA512';
    const RIPEMD160 = 'RIPEMD160';
    const MDC2 = 'MDC2';

    protected $name = __CLASS__;
    protected $fieldName = 'PBX_HASH';

    private $hashAlgorithm = array(
        HashValue::SHA224,
        HashValue::SHA256,
        HashValue::SHA384,
        HashValue::SHA512,
        HashValue::RIPEMD160,
        HashValue::MDC2
    );

    /**
     * HashValue constructor with default value as SHA512 as described into the documentation
     * @param string $value The Hash algorithm
     * @throws ValueException
     */
    public function __construct($value = HashValue::SHA512)
    {
        parent::__construct($value);
    }

    public function isValueRegular($value)
    {
        if (array_search($value, $this->hashAlgorithm, true) === false) {
            return 'Unknown algorithm ' . $value . '.';
        }

        return false;
    }

}
