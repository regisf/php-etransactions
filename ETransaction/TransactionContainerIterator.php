<?php

/**
 * Iterate only non null array items
 */
class TransactionContainerIterator implements Iterator
{
    /**
     * @var array
     */
    private $fields;

    /**
     * @var int
     */
    private $position = 0;

    /**
     * TransactionContainerIterator constructor.
     * @param array $fields
     */
    public function __construct(array $fields)
    {

        $filtered = array_filter($fields, function ($v) {
            return !is_null($v);
        });
        $this->fields = array_values($filtered);
    }

    public function current()
    {
        return $this->fields[$this->position];
    }

    public function next()
    {
        $this->position++;
    }

    public function key()
    {
        return $this->position;
    }

    public function valid()
    {
        return isset($this->fields[$this->position]);
    }

    public function rewind()
    {
        $this->position = 0;
    }
}