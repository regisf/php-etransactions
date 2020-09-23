<?php

require_once 'ValueBase.php';

class FeedbackValue extends ValueBase
{
    const ValidKey = 'MRTABCDEFGHIJjKNOoPQSUVWYZ';
    const DefaultRetour = 'Mt:M;Ref:R;Auto:A;Erreur:E';
    protected $name = __CLASS__;
    protected $fieldName = 'PBX_RETOUR';

    public function __construct($value = FeedbackValue::DefaultRetour)
    {
        parent::__construct($value);
    }

    public function isValueRegular($value)
    {
        $keyVals = explode(';', $value);
        $result = array_map(function ($kv) {
            $r = explode(':', $kv);
            if (count($r) === 1) {
                throw new ValueException('Not well formed Key:Value element for Feedback. ' .
                    'Key and Value must be separated by a colon');
            }

            return strchr(FeedbackValue::ValidKey, $r[1]);
        }, $keyVals);

        if (count($result) === 1 && $result[0] === false) {
            return 'The feedback value doesn`t contain valid data';
        }

        return false;
    }
}
