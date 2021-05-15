<?php

require __DIR__ . '/../vendor/autoload.php';

use OneCoin\StellarSdk\Keypair;

$keypair = Keypair::newFromRandom();

print $keypair->getSecret() . PHP_EOL;
// SAV76USXIJOBMEQXPANUOQM6F5LIOTLPDIDVRJBFFE2MDJXG24TAPUU7

print $keypair->getPublicKey() . PHP_EOL;
// GCFXHS4GXL6BVUCXBWXGTITROWLVYXQKQLF4YH5O5JT3YZXCYPAFBJZB
