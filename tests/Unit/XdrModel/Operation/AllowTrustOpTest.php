<?php


namespace OneCoin\StellarSdk\Test\Unit\XdrModel\Operation;


use PHPUnit\Framework\TestCase;
use OneCoin\StellarSdk\Keypair;
use OneCoin\StellarSdk\Xdr\XdrBuffer;
use OneCoin\StellarSdk\XdrModel\AccountId;
use OneCoin\StellarSdk\XdrModel\Asset;
use OneCoin\StellarSdk\XdrModel\Operation\AllowTrustOp;
use OneCoin\StellarSdk\XdrModel\Operation\Operation;

class AllowTrustOpTest extends TestCase
{
    public function testFromXdr()
    {
        $sourceOp = new AllowTrustOp(Asset::newCustomAsset('TST', Keypair::newFromRandom()), new AccountId(Keypair::newFromRandom()));
        $sourceOp->setIsAuthorized(true);

        /** @var AllowTrustOp $parsed */
        $parsed = Operation::fromXdr(new XdrBuffer($sourceOp->toXdr()));

        $this->assertTrue($parsed instanceof AllowTrustOp);

        $this->assertEquals('TST', $parsed->getAsset()->getAssetCode());
        $this->assertEquals($sourceOp->getTrustor()->getAccountIdString(), $parsed->getTrustor()->getAccountIdString());
    }
}
