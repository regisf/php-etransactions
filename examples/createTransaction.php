<?php

require_once 'ETransactions/ETransaction.php';

// Instantiate a e-Transaction object  (be shine not for real)
$transaction = new ETransaction(true);
if ($transaction->pingRemote() === false) {
    die('nable to contact the remove server');
}

// Set transaction data
$transactionData = TransactionData::fromData([
    'rang' => 7,
    'site' => 1234567,
    'id' => 123,
    'secret' => '001223489213651365165158',
    'total' => 10.0,
    'command' => 'some-customer-id',
    'holder' => 'this-is-me@somewhere.tld',
    'feedback' => 'Mt:M',
]);

$transaction->setTransactionData($transactionData);
?>

<form action="<?php echo $transaction->getServerAddress() ?>" method="post">
    <?php echo $transaction->getTransactionForm(); ?>
    <div>
        <input type="submit" value="Procéder au paiement"/>
    </div>
</form>
