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


class HMACValue extends ValueBase
{
    protected $name = __CLASS__;
    protected $fieldName = 'PBX_HMAC';

    /**
     * Compute the HMAC value at the object creation
     *
     * @param SecretValue $secretKey
     * @param string $parameters
     * @param HashValue $hashValue
     * @throws ValueException
     */
    public function __construct($secretValue, $parameters, $hashValue)
    {
        $binKey = pack('H*', $secretValue->getValue());
        $hash = strtoupper(hash_hmac($hashValue->getValue(), $parameters, $binKey));

        parent::__construct($hash);
    }
}
