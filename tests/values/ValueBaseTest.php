<?php

use PHPUnit\Framework\TestCase;

class DummyClass extends ValueBase
{
    protected $name = __CLASS__;
    protected $fieldName = 'PBX_DUMMY';
}

class ValueBaseTest extends TestCase
{
    public function testToForm()
    {
        $expected = '<input type="hidden" name="PBX_DUMMY" value="hello" />';
        $dummy = new DummyClass('hello');
        $result = $dummy->toForm();

        $this->assertSame($expected, $result);
    }
}