<?php

abstract class UrlType
{
    const Done = 'PBX_EFFECTUE';
    const Denied = 'PBX_REFUSE';
    const Canceled = 'PBX_ANNULE';
}

class UrlValue extends ValueBase
{
    private $url;

    /**
     * UrlValue constructor.
     *
     * @param string $value
     * @param string $urlType
     * @throws ValueException
     */
    public function __construct($value, $urlType)
    {
        $this->fieldName = $urlType;
        parent::__construct($value);
    }

    public function isValueRegular($value)
    {
        if (filter_var($value, FILTER_VALIDATE_URL) === false) {
            return "$value is not a valid URL";
        }

        if (!($this->fieldName === UrlType::Done || $this->fieldName === UrlType::Canceled || $this->fieldName === UrlType::Denied)) {
            return 'Url type Unknown:' . $this->fieldName;
        }

        return false;
    }
}