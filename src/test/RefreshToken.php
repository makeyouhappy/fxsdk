<?php
require_once dirname(dirname(__FILE__)) . 'FxClient.php';
require_once dirname(dirname(__FILE__)) . 'FxConfig.php';
require_once dirname(dirname(__FILE__)) . '/request/FxRefreshAuthTokenRequest.php';

$config = new FxConfig();
$config->setSecretKey("");
$config->setServerUrl("");
$request = new FxRefreshAuthTokenRequest();
$request->setHeaders([]);
$request->setBizContent([
    'app_id' => "123",
    'refresh_token' => "123"
]);
$client = new FxClient($config);
$client->execute($request);