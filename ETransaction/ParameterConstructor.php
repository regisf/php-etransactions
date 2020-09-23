<?php


class ParameterConstructor
{
    /**
     * @var TransactionData
     */
    private $container;

    /**
     * ParameterConstructor constructor.
     * @param TransactionData $container
     */
    public function __construct($container)
    {
        $this->container = $container;
    }

    /**
     * @return array Convert push all fields into an array
     */
    public function asArray()
    {
        $fields = [];

        foreach ($this->container->getIterator() as $field) {
            if ($field->getName() === 'HMACValue') {
                continue;
            }

            array_push($fields, $field->toString());
        }

        return $fields;
    }


}