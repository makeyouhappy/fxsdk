<?php
require_once dirname(dirname(__FILE__)) . 'FxClient.php';
require_once dirname(dirname(__FILE__)) . 'FxConfig.php';
require_once dirname(dirname(__FILE__)) . '/request/FxThirdLoginRequest.php';

$config = new FxConfig();
$config->setServerUrl("");
$config->setSecretKey("");
$request = new FxThirdLoginRequest();
$request->setBizContent([
    'app_id' => 123,
    'uid' => 123,
    'jump_url' => 'http://www.baidu.com',
    'valid_time' => '123',
    'web_type' => 'web'
]);
$client = new FxClient($config);
$client->execute($request);