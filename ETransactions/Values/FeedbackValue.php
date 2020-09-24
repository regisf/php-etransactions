<?php
/*
 * ETransactions - Wrapper for e-transactions.fr service.
 * Copyright (C) 2020 Regis FLORET
 *
 * This library is free software; you can redistribute it and/or
 * modify it under the terms of the GNU Lesser General Public
 * License as published by the Free Software Foundation; either
 * version 2.1 of the License, or (at your option) any later version.
 *
 * This library is distributed in the hope that it will be useful,
 * but WITHOUT ANY WARRANTY; without even the implied warranty of
 * MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the GNU
 * Lesser General Public License for more details.
 *
 * You should have received a copy of the GNU Lesser General Public
 * License along with this library; if not, write to the Free Software
 * Foundation, Inc., 51 Franklin Street, Fifth Floor, Boston, MA  02110-1301  USA
 */

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
