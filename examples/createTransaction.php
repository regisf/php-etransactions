<?php

require_once 'ETransactions/ETransaction.php';

// Instantiate a e-Transaction object  (be shine not for real)
$transaction = new ETransaction(true);
if ($transaction->pingRemote() === false) {
    die('nable to contact the remove server');
}

// Set transaction data
$transactionData = TransactionData::fromData([
    'total' => 10.0,
    'rang' => 7,
    'site' => 1234567,
    'id' => 123,
    'devise' => Devises::EUR,
    'command' => 'some-customer-id',
    'hash' => HashValue::SHA512,
    'holder' => 'this-is-me@somewhere.tld',
    'time' => 1600424772,
    'feedback' => 'Mt:M',
    'secret' => '001223489213651365165158'
]);

$transaction->setTransactionData($transactionData);
?>

<form action="<?php echo $transaction->getServerAddress() ?>" method="post">
    <?php echo $transaction->getTransactionForm(function ($el) {
        return "<div>$el</div>\n";
    }); ?>
    <input type="submit" value="Procéder au paiement"/>
</form>

