<?php

require_once 'Exceptions/ETransactionException.php';

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
    private $transactionContainer;

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

        $this->transactionContainer = $data;
    }

    /**
     * Test the remote server. Either preprod and production servers expose a simple page:
     * load.html to test the server
     *
     * @return bool True on success
     */
    public function pingRemote()
    {
        $address = $this->constructPingUrl();
        $doc = new DOMDocument();
        try {
            $result = $doc->loadHTMLFile($address);
            if (! $result) {
                die('Unable to ping the server : '. $address);
            }

            $status = $doc->getElementById('server_status')->textContent;
            return $status === 'OK';

        } catch (Exception $e) {
            return false;
        }
    }

    private function constructPingUrl()
    {
        return $this->scheme . $this->getServer() . '.' . $this->pingAddress;
    }

    private function constructUrl()
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
