<?php

require_once "ETransaction/TransactionContainerIterator.php";

use PHPUnit\Framework\TestCase;

class TransactionContainerIteratorTest extends TestCase
{
    public function testIterator()
    {
        $arr = [null, "one", null, null, "two", null, "three", "four", null];
        $expected = ["one", "two", "three", "four"];
        $it = new TransactionContainerIterator($arr);

        $result = [];
        foreach ($it as $item) {
            array_push($result, $item);
        }

        $this->assertEquals($expected[0], $result[0]);
        $this->assertEquals($expected[1], $result[1]);
        $this->assertEquals($expected[2], $result[2]);
        $this->assertEquals($expected[3], $result[3]);
    }
}
