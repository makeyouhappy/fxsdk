<?php

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