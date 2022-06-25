<?php

class CheckSignUtil
{
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
}

$bizContent = [
    'app_id' => '',
    'app_secret' => '',
    'rand_str' => '2k3j3j4'
];
$secretKey = "123";
$sign = CheckSignUtil::createSign($bizContent + ['secret_key' => $secretKey]);