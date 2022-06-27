<?php
namespace FxSdk\request;

class FxThirdLoginRequest
{
    protected $headers;
    protected $postMethod = 'GET';
    protected $isRedirect = true;

    protected $bizContent;

    public function getMethodName()
    {
        return "/api/thirdParty/thirdLogin";
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

    public function getIsRedirect()
    {
        return $this->isRedirect;
    }

    public function getUriParams()
    {
        $str = "?";
        foreach ($this->bizContent as $key => $value) {
            $str .= $key . "=" . $value . "&";
        }
        return rtrim($str, '&');
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