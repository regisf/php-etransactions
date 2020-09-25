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
        $this->done = $done;
    }

    public function getDoneCallback()
    {
        return $this->done;
    }

    public function setDeniedCallback($denied)
    {
        $this->denied = $denied;
    }

    public function getDeniedCallback()
    {
        return $this->denied;
    }

    public function setCanceledCallback($cancel)
    {
        $this->cancel = $cancel;
    }

    public function getCanceledCallback()
    {
        return $this->cancel;
    }
}