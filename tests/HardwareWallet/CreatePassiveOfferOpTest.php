<?php


namespace OneCoin\StellarSdk\Test\HardwareWallet;

use phpseclib3\Math\BigInteger;
use OneCoin\StellarSdk\Keypair;
use OneCoin\StellarSdk\Test\Util\HardwareWalletIntegrationTest;
use OneCoin\StellarSdk\XdrModel\Asset;
use OneCoin\StellarSdk\XdrModel\Operation\CreatePassiveOfferOp;
use OneCoin\StellarSdk\XdrModel\Price;

class CreatePassiveOfferOpTest extends HardwareWalletIntegrationTest
{
    /**
     * @group requires-hardwarewallet
     */
    public function testNewPassiveOffer()
    {
        $sourceKeypair = Keypair::newFromMnemonic($this->mnemonic);
        $sellingAsset = Asset::newNativeAsset();
        $buyingAsset = Asset::newCustomAsset('USD', Keypair::newFromMnemonic($this->mnemonic, 'usd issuer'));

        $amount = 200;
        $price = new Price(674614, 1000000);

        $operation = new CreatePassiveOfferOp($sellingAsset, $buyingAsset, $amount, $price);

        $transaction = $this->horizonServer
            ->buildTransaction($sourceKeypair)
            ->setSequenceNumber(new BigInteger(4294967296))
            ->addOperation($operation);
        $knownSignature = $transaction->signWith($this->privateKeySigner);

        $this->manualVerificationOutput(join(PHP_EOL, [
            base64_encode($transaction->toXdr()),
            'Passive Offer: new offer',
            '       Source: ' . $sourceKeypair->getPublicKey(),
            '      Selling: ' . $amount . 'XLM',
            '       Buying: ' . 'For ' . $price . ' per ' . $buyingAsset->getAssetCode() . ' (' . $buyingAsset->getIssuer()->getAccountIdString() . ')',
            '',
            'B64 Transaction: ' . base64_encode($transaction->toXdr()),
            '      Signature: ' . $knownSignature->getWithoutHintBase64(),
        ]));
        $hardwareSignature = $transaction->signWith($this->horizonServer->getSigningProvider());

        $this->assertEquals($knownSignature->toBase64(), $hardwareSignature->toBase64());
    }

    /**
     * @group requires-hardwarewallet
     */
    public function testDeletePassiveOffer()
    {
        $sourceKeypair = Keypair::newFromMnemonic($this->mnemonic);
        $sellingAsset = Asset::newNativeAsset();
        $buyingAsset = Asset::newCustomAsset('USD', Keypair::newFromMnemonic($this->mnemonic, 'usd issuer'));

        $amount = 0;
        $price = new Price(674614, 1000000);

        $operation = new CreatePassiveOfferOp($sellingAsset, $buyingAsset, $amount, $price);

        $transaction = $this->horizonServer
            ->buildTransaction($sourceKeypair)
            ->setSequenceNumber(new BigInteger(4294967296))
            ->addOperation($operation);
        $knownSignature = $transaction->signWith($this->privateKeySigner);

        $this->manualVerificationOutput(join(PHP_EOL, [
            base64_encode($transaction->toXdr()),
            'Passive Offer: delete offer',
            '       Source: ' . $sourceKeypair->getPublicKey(),
            '      Selling: ' . $amount . 'XLM',
            '       Buying: ' . 'For ' . $price . ' per ' . $buyingAsset->getAssetCode() . ' (' . $buyingAsset->getIssuer()->getAccountIdString() . ')',
        ]));
        $hardwareSignature = $transaction->signWith($this->horizonServer->getSigningProvider());

        $this->assertEquals($knownSignature->toBase64(), $hardwareSignature->toBase64());
    }
}
