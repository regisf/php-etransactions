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

require_once __DIR__ . '/Exceptions/ETransactionException.php';
require_once __DIR__ . '/TransactionData.php';
require_once __DIR__ . '/Devises.php';


/**
 * Crédit Agricole e-Transaction Library
 */
class ETransaction
{
    private $preprod = false;
    private $scheme = 'https://';
    private $postfix = 'e-transactions.fr/cgi/MYchoix_pagepaiement.cgi';
    private $pingAddress = 'e-transactions.fr/load.html';

    private $servers = [
        'preprod' => ['preprod-tpeweb'],
        'prod' => ['tpeweb'], // , 'tpeweb1']
    ];
    /**
     * @var TransactionData
     */
    private $transactionData;

    /**
     * ETransactions constructor.
     *
     * @param false $usePreprod If set to True, we will use the preproduction server
     */
    public function __construct($usePreprod = false)
    {
        $this->preprod = $usePreprod;
    }

    /**
     * Set the transaction data. If the TransactionData is not valid,
     * throw an ETransactionException
     *
     * @param TransactionData $data The data for the transaction
     * @throws ETransactionException
     * @see TransactionData::isValid
     */
    public function setTransactionData(TransactionData $data)
    {
        if (!$data->isValid()) {
            throw new ETransactionException('Transaction is invalid');
        }

        $this->transactionData = $data;
    }

    /**
     * @return TransactionData
     */
    public function getTransactionData()
    {
        return $this->transactionData;
    }

    /**
     * Test the remote server. Either preprod and production servers expose a simple pages:
     * load.html to test the server
     *
     * @return bool True on success
     */
    public function pingRemote()
    {
        $address = $this->constructPingUrl();
        $status = $this->loadStatusValue($address);

        return $status === 'OK';
    }

    /**
     * Load the status from the server. It's a simple pages that contains
     * a simple tag <div> with the id: server_status.
     *
     * @param $address
     * @return string The tag content
     */
    public function loadStatusValue($address)
    {
        $doc = new DOMDocument();
        $doc->loadHTMLFile($address);

        return $doc
            ->getElementById('server_status')
            ->textContent;
    }

    private function constructPingUrl()
    {
        return $this->scheme . $this->getServer() . '.' . $this->pingAddress;
    }

    public function getTransactionForm()
    {
        return $this->getTransactionData()->toForm();
    }

    public function getServerAddress()
    {
        return $this->scheme . $this->getServer() . '.' . $this->postfix;
    }

    private function getServer()
    {
        return $this->servers[$this->getServerKey()][0];
    }

    public function getServerKey()
    {
        return $this->isSandbox() === true ? 'preprod' : 'prod';
    }

    public function isSandbox()
    {
        return $this->preprod;
    }
}
