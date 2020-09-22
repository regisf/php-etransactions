<?php

use PHPUnit\Framework\TestCase;

class FeedbackValueTest extends TestCase
{

    public function testIsValidWithoutCorrectValue()
    {
        $this->expectException(ValueException::class);
        new FeedbackValue("Mt:i");
    }

    public function testNotWellFormedValue()
    {
        $this->expectException(ValueException::class);
        new FeedbackValue("Mti");
    }

    public function testIsValueRegular()
    {
        $expected = 'Mt:M;Ref:R;Auto:A;Erreur:E';
        $feedbackValue = new FeedbackValue($expected);
        $value = $feedbackValue->getValue();
        $this->assertSame($value, $expected);
    }

    public function testToString()
    {
        $expected = 'Mt:M;Ref:R;Auto:A;Erreur:E';
        $feedbackValue = new FeedbackValue($expected);
        $value = $feedbackValue->toString();
        $this->assertSame($value, "PBX_RETOUR=$expected");
    }
}
