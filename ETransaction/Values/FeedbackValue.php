<?php
require_once 'ValueBase.php';

class FeedbackValue extends ValueBase
{
    const DefaultRetour = 'Mt:M;Ref:R;Auto:A;Erreur:E';
    protected $name = __CLASS__;

    public function __construct($value = FeedbackValue::DefaultRetour)
    {
        parent::__construct($value);
    }

    public function isValueRegular($value)
    {
        return false;
    }

    public function toString()
    {
        return 'PBX_RETOUR=' . $this->getValue();
    }
}
