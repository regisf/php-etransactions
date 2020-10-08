<?php

require_once __DIR__ . '/Exceptions/TransactionResultException.php';
require_once __DIR__ . '/Values/TotalValue.php';
require_once __DIR__ . '/Values/UUIDValue.php';

class TransactionResult
{
    private $amount;
    /**
     * @var UUIDValue
     */
    private $reference;
    private $paybox_id;
    private $auth_id;
    private $subscription_id;
    private $credit_card_type;
    private $credit_card_end;
    private $transaction_response_code;
    private $country_code;
    private $credit_card_id_end;
    private $payement_type;
    private $transaction_datetime;
    private $paybox_transaction_id;
    private $paybox_transaction_date;
    private $signature;

    private function __construct($raw)
    {
        $this->raw = $raw;
    }

    public static function fromRequest(array $request, $raw = '')
    {
        // B is required as response. If it not exists, we are in edition mode
        if (!isset($request['B'])) {
            return null;
        }

        $transactionResult = new TransactionResult($raw);

        if (isset($request['A'])) {
            $transactionResult->auth_id = $request['A'];
        }

        $transactionResult->subscription_id = $request['B'];

        if (isset($request['C'])) {
            $transactionResult->credit_card_type = $request['C'];
        }

        if (isset($request['D'])) {
            $transactionResult->creit_card_end = $request['D'];
        }

        $transactionResult->transaction_response_code = $request['E'];
        $transactionResult->country_code = $request['I'];
        $transactionResult->amount = new TotalValue(floatval($request['M']) / 100.0);

        if (isset($request['N'])) {
            $transactionResult->credit_card_id_end = $request['N'];
        }

        if (isset($request['P'])) {
            $transactionResult->payement_type = $request['P'];
        }

        if (isset($request['Q'])) {
            $transactionResult->transaction_datetime = $request['Q'];
        }
        $transactionResult->reference = new UUIDValue($request['R']);
        $transactionResult->paybox_id = $request['T'];
        $transactionResult->paybox_transaction_id = $request['S'];
        if (isset($request['W'])) {
            $transactionResult->paybox_transaction_date = $request['W'];
        }
        $transactionResult->signature = $request['K'];
//        $transactionResult->controlSignature();
        return $transactionResult;
    }

    /**
     * @return UUIDValue
     */
    public function getReference()
    {
        return $this->reference;
    }

    /**
     * @return mixed
     */
    public function getPayboxTransactionId()
    {
        return $this->paybox_transaction_id;
    }

    /**
     * @return TotalValue
     */
    public function getAmount()
    {
        return $this->amount;
    }

    private function controlSignature()
    {
        $signature = base64_decode($this->signature);
        $public_key = openssl_pkey_get_public(__DIR__ . '/PublicKey.pem');
        if (openssl_verify($this->raw, $signature, $public_key) === false) {
            throw new TransactionResultException('Invalid signature: ' . openssl_error_string());
        }
    }
}