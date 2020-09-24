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


/**
 * Iterate only non null array items
 */
class TransactionDataIterator implements Iterator
{
    /**
     * @var array
     */
    private $fields;

    /**
     * @var int
     */
    private $position = 0;

    /**
     * TransactionContainerIterator constructor.
     * @param array $fields
     */
    public function __construct(array $fields)
    {

        $filtered = array_filter($fields, function ($v) {
            return !is_null($v);
        });
        $this->fields = array_values($filtered);
    }

    public function current()
    {
        return $this->fields[$this->position];
    }

    public function next()
    {
        $this->position++;
    }

    public function key()
    {
        return $this->position;
    }

    public function valid()
    {
        return isset($this->fields[$this->position]);
    }

    public function rewind()
    {
        $this->position = 0;
    }
}