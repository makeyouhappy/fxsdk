<?php
namespace FxSdk\request;

class FxRefreshAuthTokenRequest
{
    protected $headers = [];
    protected $postMethod = 'POST';
    protected $bizContent;

    public function getMethodName()
    {
        return "/api/auth/refresh";
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