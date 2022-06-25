<?php

class FxConfig
{
    private $serverUrl = "";
    private $secretKey = "";
    private $format = 'application/json';
    private $charset = 'charset=utf-8';

    public function setServerUrl($serverUrl)
    {
        $this->serverUrl = $serverUrl;
    }

    public function getServerUrl()
    {
        return $this->serverUrl;
    }

    public function setSecretKey($secretKey)
    {
        $this->secretKey = $secretKey;
    }

    public function getSecretKey()
    {
        return $this->secretKey;
    }

    public function setFormat($format)
    {
        $this->format = $format;
    }

    public function getFormat()
    {
        return $this->format;
    }

    public function setCharset($charset)
    {
        $this->charset = $charset;
    }

    public function getCharset()
    {
        return $this->charset;
    }
}