<?php

/**
 * Adds a new signer to an existing account
 */


require '../vendor/autoload.php';

use \OneCoin\StellarSdk\Keypair;
use \OneCoin\StellarSdk\Server;
use \OneCoin\StellarSdk\XdrModel\Operation\SetOptionsOp;
use \OneCoin\StellarSdk\XdrModel\SignerKey;
use \OneCoin\StellarSdk\XdrModel\Signer;


$server = Server::testNet();

// GB7H6NXC42ABH7C4IBQSYXKAFNAC4V4ZDNRXBVH6MKLIRB6YLXC7RWYD
$currentAccount = Keypair::newFromSeed('SD2MKS6CGVTFH7NJZFXQGXDQSDOLRLCRY7JN6WPULMJPCGBNLK4KU34R');


// GBD7ENB2PF6WFSKH6L6BBBMULSWL4XQPCA4CDLEMMNAK5RINHQO3H3GB
$newSigner = Keypair::newFromSeed('SB7X4LP4CS3YOFECRZFYOY63Q4GATOIDRWTUR3VQTLCIXY22OB45NHED');


$optionsOperation = new SetOptionsOp();

$optionsOperation->setMasterWeight(10);

$signerKey = SignerKey::fromKeypair($newSigner);
$newAccountSigner = new Signer($signerKey, 1);
$optionsOperation->updateSigner($newAccountSigner);

// Submit to the network
$server->buildTransaction($currentAccount->getPublicKey())
    ->addOperation($optionsOperation)
    ->submit($currentAccount->getSecret());
