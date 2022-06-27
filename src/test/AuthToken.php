<?php

$config = new FxConfig();
$config->setSecretKey("");
$config->setServerUrl("");
$request = new FxAuthTokenRequest();
$request->setBizContent([
    'app_id' => "123",
    'refresh_token' => "123"
]);
$client = new FxClient($config);
$client->execute($request);