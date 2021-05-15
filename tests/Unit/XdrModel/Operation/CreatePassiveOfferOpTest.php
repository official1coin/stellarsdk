<?php


namespace OneCoin\StellarSdk\Test\Unit\XdrModel\Operation;


use PHPUnit\Framework\TestCase;
use OneCoin\StellarSdk\Keypair;
use OneCoin\StellarSdk\Xdr\XdrBuffer;
use OneCoin\StellarSdk\XdrModel\Asset;
use OneCoin\StellarSdk\XdrModel\Operation\CreatePassiveOfferOp;
use OneCoin\StellarSdk\XdrModel\Operation\Operation;
use OneCoin\StellarSdk\XdrModel\Price;

class CreatePassiveOfferOpTest extends TestCase
{
    public function testFromXdr()
    {
        $sellingAsset = Asset::newCustomAsset('SELLING', Keypair::newFromRandom());
        $buyingAsset = Asset::newCustomAsset('BUYING', Keypair::newFromRandom());
        $amount = 9000.00001;
        $price = new Price(1, 4000);

        $sourceOp = new CreatePassiveOfferOp(
            $sellingAsset,
            $buyingAsset,
            $amount,
            $price
        );

        /** @var CreatePassiveOfferOp $parsed */
        $parsed = Operation::fromXdr(new XdrBuffer($sourceOp->toXdr()));

        $this->assertTrue($parsed instanceof CreatePassiveOfferOp);

        $this->assertEquals($sellingAsset->getAssetCode(), $parsed->getSellingAsset()->getAssetCode());
        $this->assertEquals($buyingAsset->getAssetCode(), $parsed->getBuyingAsset()->getAssetCode());
        $this->assertEquals($amount, $parsed->getAmount()->getScaledValue());
        $this->assertEquals(.00025, $parsed->getPrice()->toFloat());
    }
}
