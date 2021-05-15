<?php


namespace OneCoin\StellarSdk\Test\Unit\XdrModel\Operation;


use PHPUnit\Framework\TestCase;
use OneCoin\StellarSdk\Keypair;
use OneCoin\StellarSdk\Xdr\XdrBuffer;
use OneCoin\StellarSdk\XdrModel\Asset;
use OneCoin\StellarSdk\XdrModel\Operation\AccountMergeOp;
use OneCoin\StellarSdk\XdrModel\Operation\ChangeTrustOp;
use OneCoin\StellarSdk\XdrModel\Operation\Operation;

class ChangeTrustOpTest extends TestCase
{
    public function testFromXdr()
    {
        $sourceOp = new ChangeTrustOp(Asset::newCustomAsset('TRUST', Keypair::newFromRandom()), 8888);

        /** @var ChangeTrustOp $parsed */
        $parsed = Operation::fromXdr(new XdrBuffer($sourceOp->toXdr()));

        $this->assertTrue($parsed instanceof ChangeTrustOp);

        $this->assertEquals('TRUST', $parsed->getAsset()->getAssetCode());
        $this->assertEquals(8888, $parsed->getLimit()->getScaledValue());
    }
}
