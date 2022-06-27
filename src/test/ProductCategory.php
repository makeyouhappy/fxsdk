<?php

$config = new FxConfig();
$config->setSecretKey("");
$config->setServerUrl("");
$request = new FxProductCategoryRequest();
$request->setHeaders(['access-token:12332123']);
$request->setBizContent([
    'pid' => 0
]);
$client = new FxClient($config);
$client->execute($request);