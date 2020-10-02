# php-etransactions
PHP library for [Crédit Agricole E-Transactions](https://e-transaction.fr) portail. This is an integrated paiement 
solution. 

Warning: The full solution isn't fully implemented. See [Missing](#missing-features).

Crédit Agricole is later named "CA" in this documentation.

You also should be able to use this library with the Verifone Paybox system. 

_Note: The system is a french system, unfortunatly there's a lot of french words_.

## Install

You could either use

* Composer `composer install etransactions/etransactions`
* Zip file 
* GIT

## Usage

You must have a [Crédit Agricole e-transactions](https://e-transaction.fr) account.

### Required values
You need four things:

* You secret key as given on the admin system. 
* The rang ID
* The site ID
* The customer ID

For now, only required fields are implemented.

Required fields are:

* Total: The payment amount 
* Device: Anything you want as long it is the euro (Default is EURO)
* Command: Your own customer ID
* Hash algorithm: How you compute the HMAC key? (Default is SHA512)
* Time: The desired transaction time as a timestamp (Default is now) 
* Secret: The secret key as generated on [the backend](https://admin.e-transactions.fr/)
* Feedback: How the [e-transactions](https://e-transactions.fr) system will inform you how the 
transaction passed off.
* Holder: The email address of your customer (Porteur into the CA documentation)

**Caution**
The holder field is not defined as required file internally and will not be checked. You might have an
error on form submission.

Required fields with default value could be ignored. 

### Example

First you must create the main object to work with:

```php
$transaction = new ETransaction(true);
```

The `ETransaction` object don't contains the data for the transaction. `ETransaction` is the vector to
send the data not the container.

Then create the data container:

```php
// Using the factory
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
```

or

```php
// Using pure OOP
$data = new TransactionData();
$data->setRang(new RangValue(7));
$data->setSite(new SiteValue(1234567));
$data->setId(new IDValue(123));
$data->setSecret(new SecretValue('001223489213651365165158'));
$data->setTotal(new TotalValue(10.0));
$data->setCommand(new CommandValue('some-customer-id'));
$data->setHolder(new HolderValue('this-is-me@somewhere.tld'));
$data->setFeedback(new FeedbackValue('Mt:M'));
```

As you may see we don't pass atomic values directly but we use an immutable object `*Value`. This 
because we want to be sure that the passed value is correct and consistent.

Now set the data and you are ready to display the form:

```php
$transaction->setTransactionData($data);
echo $transaction->getTransactionForm();
```

will display:

```html
<input type="hidden" name="PBX_SITE" value="1234567" />
<input type="hidden" name="PBX_RANG" value="7" />
<input type="hidden" name="PBX_IDENTIFIANT" value="123" />
<input type="hidden" name="PBX_DEVISE" value="978" />
<input type="hidden" name="PBX_CMD" value="some-customer-id" />
<input type="hidden" name="PBX_RETOUR" value="Mt:M" />
<input type="hidden" name="PBX_PORTEUR" value="this-is-me@somewhere.tld" />
<input type="hidden" name="PBX_TOTAL" value="10" />
<input type="hidden" name="PBX_HASH" value="SHA512" />
<input type="hidden" name="PBX_HMAC" value="DD753E2CB8AA03C8AE3C611310E9106E7EF4D5607BB1E49B935784720670175E62E8F03D1D781A45BAB7BC91A75F43C7DA6470DCBCF0BD9D8DC6A7E9FB50E0FA" />    
```

See the [examples directory](./examples) for full example.

### Return URLs

You are able to set three return urls for the transaction. All three url are called with feedback 
parameters (see PBX_RETOUR into the documentation).

* Done (`EFFECTUE`): The URL when the transaction is successful
* Denied (`REFUSE`): The URL when the pavement is denied. 
* Canceled (`ANNULE`): The URL when the user cancel the payement.

To set callback addresses, add related keys in the `TransactionData::fromData` factory:

```php
$transactionData = TransactionData::fromData([
    // Required fields above
    'callbacks' => [
        'done' => 'https://my-website.com/payement/done',
        'denied' => 'https://my-website.com/payement/denied',
        'canceled' => 'https://my-website.com/payement/canceled',
    ]
]);
```

or 

```php
$transactionData = new TransactionData();
$transactionData->setDoneCallback(new UrlValue('https://my-website.com/payement/done', UrlType::Done));
$transactionData->setDeniedCallback(new UrlValue('https://my-website.com/payement/denied', UrlType::Denied));
$transactionData->setCanceledCallback(new UrlValue('https://my-website.com/payement/canceled', UrlType::Canceled));
```



### Missing features

* Card choice,
* Batch processing,
* Cash collection management,
* Recurring payments,
* Advanced features,
* Subscription management
