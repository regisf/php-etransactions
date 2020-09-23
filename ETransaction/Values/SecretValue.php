<?php

require_once 'ValueBase.php';

/**
 * The SecretValue class is just a immutable container. The key by itself is a string
 *
 * @see ValueBase
 */
class SecretValue extends ValueBase
{
    protected $name = __CLASS__;
}
