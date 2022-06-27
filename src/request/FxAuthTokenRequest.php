<?php
namespace FxSdk\request;

class FxAuthTokenRequest
{
    protected $headers = [];
    protected $postMethod = 'POST';
    protected $bizContent;

    public function getMethodName()
    {
        return "/api/auth/token";
    }

    public function setBizContent($params)
    {
        $this->bizContent = $params;
    }

    public function getBizContent()
    {
        return $this->bizContent;
    }

    public function getPostMethod()
    {
        return $this->postMethod;
    }

    public function setHeaders($headers)
    {
        $this->headers = $headers;
    }

    public function getHeaders()
    {
        return $this->headers;
    }
}