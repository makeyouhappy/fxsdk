<?php

class FxClient
{
    public $appId;
    public $config;

    public function __construct()
    {
        if (func_num_args() == 1 && func_get_arg(0) instanceof FxConfig) {
            $config = func_get_arg(0);
            $this->config = $config;
        }
    }

    public function setFxConfig($config)
    {
        $this->config = $config;
    }

    public function execute($request)
    {
        if (!$this->config) {
            throw new Exception("FxConfig not configured");
        }
        if (!$this->config->getServerUrl()) {
            throw new Exception("ServerUrl not configured");
        }
        if (!$this->config->getSecretKey()) {
            throw new Exception("SecretKey not configured");
        }

        //生成签名
        $bizContent = $request->getBizContent();
        $bizContent['rand_str'] = $this->random_string('alnum', 6);
        $sign = self::createSign($bizContent + ['secret_key' => $this->config->getSecretKey()]);
        $url = $this->config->getServerUrl() . $request->getMethodName();

        $contentType = ['Content-Type: ' . $this->config->getFormat() . ';' . $this->config->getCharset()];
        $headers = array_merge($request->getHeaders(), ['sign:' . $sign], $contentType);

        //进行跳转
        if (method_exists($request, 'getIsRedirect') && $request->getIsRedirect()) {
            $url .= $request->getUriParams() . '&sign=' . $sign;
            redirect($url);
        }

        $param = json_encode($bizContent);
        return $this->curl($url, $headers, $param);
    }

    /**
     * @param $url
     * @param array $headers $headers = ['apiType: api', 'Content-Type: application/json'];
     * @param string $bodys json字符串
     * @return bool|string
     */
    public function curl($url, array $headers, $bodys)
    {
        $curl = curl_init();
        curl_setopt_array($curl, array(
            CURLOPT_URL => $url,
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_ENCODING => '',
            CURLOPT_MAXREDIRS => 10,
            CURLOPT_TIMEOUT => 0,
            CURLOPT_FOLLOWLOCATION => true,
            CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
            CURLOPT_CUSTOMREQUEST => 'POST',
            CURLOPT_POSTFIELDS => $bodys,
            CURLOPT_HTTPHEADER => $headers
        ));

        $response = curl_exec($curl);
        curl_close($curl);
        return $response;
    }

    /**
     * 创建签名
     * @param $param
     * @return string
     */
    public static function createSign($param)
    {
        $secretKey = $param['secret_key'];
        unset($param['sign'], $param['secret_key']);
        //除去数组中的空值和签名参数
        $param = self::paraFilter($param);
        $ssign = self::generateSign($param, $secretKey);
        return $ssign;
    }

    /**
     * 除去数组中的空值和签名参数
     * @param $para
     * @return array
     */
    private static function paraFilter($para)
    {
        $para_filter = array();
        foreach ($para as $key => $val) {
            if ($key == "sign" || $key == "sign_type" || $key == "secret_key" || $val === "") {
                continue;
            } else {
                $para_filter[$key] = $para[$key];
            }
        }
        return $para_filter;
    }

    /**
     * 生成签名
     * @param $param
     * @param $secretKey
     * @return string
     */
    public static function generateSign($param, $secretKey)
    {
        ksort($param);
        $string = md5(self::getSignContent($param) . '&key=' . $secretKey);
        return strtoupper($string);
    }

    /**
     * 排列组合数据为字符串
     * @param $data
     * @return string
     */
    public static function getSignContent($data)
    {
        $buff = '';

        foreach ($data as $k => $v) {
            if (!is_array($v)) {
                $v = trim($v);
            }
            $buff .= ($k != 'sign' && $v !== '' && !is_array($v)) ? $k . '=' . $v . '&' : '';
        }

        return trim($buff, '&');
    }

    public function random_string($type = 'alnum', $len = 8)
    {
        switch ($type) {
            case 'basic':
                return mt_rand();
            case 'alnum':
            case 'numeric':
            case 'nozero':
            case 'alpha':
                switch ($type) {
                    case 'alpha':
                        $pool = 'abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';
                        break;
                    case 'alnum':
                        $pool = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';
                        break;
                    case 'numeric':
                        $pool = '0123456789';
                        break;
                    case 'nozero':
                        $pool = '123456789';
                        break;
                }
                return substr(str_shuffle(str_repeat($pool, ceil($len / strlen($pool)))), 0, $len);
            case 'unique': // todo: remove in 3.1+
            case 'md5':
                return md5(uniqid(mt_rand()));
            case 'encrypt': // todo: remove in 3.1+
            case 'sha1':
                return sha1(uniqid(mt_rand(), TRUE));
        }
    }
}