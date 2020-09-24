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

class ParameterConstructor
{
    /**
     * @var TransactionData
     */
    private $container;

    /**
     * ParameterConstructor constructor.
     * @param TransactionData $container
     */
    public function __construct($container)
    {
        $this->container = $container;
    }

    /**
     * @return array Convert push all fields into an array
     */
    public function asArray()
    {
        $fields = [];

        foreach ($this->container->getIterator() as $field) {
            if ($field->getName() === 'HMACValue') {
                continue;
            }

            array_push($fields, $field->toString());
        }

        return $fields;
    }


}