<?php


class TransactionCallbacks
{
    /**
     * @var UrlValue
     */
    private $done;

    /**
     * @var UrlValue
     */
    private $cancel;

    /**
     * @var UrlValue
     */
    private $denied;


    public function setDoneCallback($done)
    {
        if (gettype($done) === 'string') {
            $done = new UrlValue($done, UrlType::Done);
        }
        $this->done = $done;
    }

    public function getDoneCallback()
    {
        return $this->done;
    }

    public function setDeniedCallback($denied)
    {
        if (gettype($denied) === 'string') {
            $denied = new UrlValue($denied, UrlType::Denied);
        }

        $this->denied = $denied;
    }

    public function getDeniedCallback()
    {
        return $this->denied;
    }

    public function setCanceledCallback($cancel)
    {
        if (gettype($cancel) === 'string') {
            $cancel = new UrlValue($cancel, UrlType::Canceled);
        }

        $this->cancel = $cancel;
    }

    public function getCanceledCallback()
    {
        return $this->cancel;
    }
}