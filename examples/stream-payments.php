<?php

require '../vendor/autoload.php';

use \OneCoin\StellarSdk\Horizon\ApiClient;
use \OneCoin\StellarSdk\Model\AssetTransferInterface;

$client = ApiClient::newPublicClient();

$client->streamPayments('now', function (AssetTransferInterface $assetTransfer) {
    printf(
        '[%s] [%s] %s from %s -> %s' . PHP_EOL,
        (new \DateTime())->format('Y-m-d h:i:sa'),
        $assetTransfer->getAssetTransferType(),
        $assetTransfer->getAssetAmount(),
        $assetTransfer->getFromAccountId(),
        $assetTransfer->getToAccountId()
    );
});
