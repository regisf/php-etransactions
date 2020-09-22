<?php


class ParameterConstructor
{
    /**
     * @var TransactionData
     */
    private $container;

    /**
     * @var bool
     */
    private $withoutHMAC;

    /**
     * ParameterConstructor constructor.
     * @param TransactionData $container
     * @param bool $withoutHMAC if set, don't add the HMAC field
     */
    public function __construct($container, $withoutHMAC)
    {
        $this->container = $container;
        $this->withoutHMAC = $withoutHMAC;
    }

    /**
     * @return array Convert push all fields into an array
     */
    public function asArray()
    {
        $fields = [];

        foreach ($this->container->getIterator() as $field) {
            if ($this->withoutHMAC === true && $field->getName() === 'HMACValue') {
                continue;
            }

            array_push($fields, $field->toString());
        }

        return $fields;
    }


}