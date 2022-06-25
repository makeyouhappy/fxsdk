<?php

#加密
$str = "uid";
$secrct_key = "";
openssl_encrypt($str, 'AES-256-ECB', $secrct_key, 0, '');

#解密
$str = "";
$secrct_key = "";
openssl_decrypt($str, 'AES-256-ECB', $secrct_key, 0, '');