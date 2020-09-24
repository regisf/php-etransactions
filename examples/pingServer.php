<?php
/*
 * Demonstrate how to use ETransactions::pingRemote
 */

require_once 'ETransactions/ETransaction.php';


echo("Testing preprod server... ");
$transaction = new ETransaction(true);
$result = $transaction->pingRemote();
echo ($result === true ? "OK" : 'FAIL') . "\n";

echo("Testing prod server...    ");
$transaction = new ETransaction();
$result = $transaction->pingRemote();
echo  ($result === true ? "OK" : 'FAIL') . "\n";

echo ("Done\n");
