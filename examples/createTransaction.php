<?php

// Instantiate a e-Transaction object  (be shine not for real)
$transaction = new ETransaction(true);

// Set transaction data
$transactionData = TransactionData::fromData([

]);

$transaction->setTransactionData($transactionData);
