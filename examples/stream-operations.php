<?php

require '../vendor/autoload.php';

use \OneCoin\StellarSdk\Horizon\ApiClient;
use \OneCoin\StellarSdk\Model\Operation;

$client = ApiClient::newPublicClient();

$client->streamOperations('now', function (Operation $operation) {
    printf(
        '[%s] %s' . PHP_EOL,
        (new \DateTime())->format('Y-m-d h:i:sa'),
        $operation->getType()
    );
});
