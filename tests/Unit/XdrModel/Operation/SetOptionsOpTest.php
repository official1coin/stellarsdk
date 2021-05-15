<?php


namespace Tests\Unit\XdrModel\Operation;


use PHPUnit\Framework\TestCase;
use OneCoin\StellarSdk\Keypair;
use OneCoin\StellarSdk\Xdr\XdrBuffer;
use OneCoin\StellarSdk\XdrModel\Operation\AccountMergeOp;
use OneCoin\StellarSdk\XdrModel\Operation\Operation;
use OneCoin\StellarSdk\XdrModel\Operation\SetOptionsOp;
use OneCoin\StellarSdk\XdrModel\Signer;
use OneCoin\StellarSdk\XdrModel\SignerKey;

class SetOptionsOpTest extends TestCase
{
    public function testFlags()
    {
        $op = new SetOptionsOp();

        $op->setAuthRequired(true);
        $op->setAuthRevocable(false);
        $this->assertTrue($op->isAuthRequired());
        $this->assertFalse($op->isAuthRevocable());
    }


    public function testFromXdr()
    {
        $inflationDestinationKeypair = Keypair::newFromRandom();
        $masterWeight = 10;
        $highThreshold = 9;
        $mediumThreshold = 8;
        $lowThreshold = 7;
        $homeDomain = 'example.com';

        $signer = new Signer(SignerKey::fromHashX('hashx'), 6);

        $sourceOp = new SetOptionsOp();
        $sourceOp->setInflationDestination($inflationDestinationKeypair->getPublicKey());
        $sourceOp->setAuthRequired(true);
        $sourceOp->setAuthRevocable(false);
        $sourceOp->setMasterWeight($masterWeight);
        $sourceOp->setHighThreshold($highThreshold);
        $sourceOp->setMediumThreshold($mediumThreshold);
        $sourceOp->setLowThreshold($lowThreshold);
        $sourceOp->setHomeDomain($homeDomain);
        $sourceOp->updateSigner($signer);


        /** @var SetOptionsOp $parsed */
        $parsed = Operation::fromXdr(new XdrBuffer($sourceOp->toXdr()));

        $this->assertTrue($parsed instanceof SetOptionsOp);

        $this->assertEquals($inflationDestinationKeypair->getAccountId(), $parsed->getInflationDestinationAccount()->getAccountIdString());
        $this->assertEquals(true, $parsed->isAuthRequired());
        $this->assertEquals(false, $parsed->isAuthRevocable());
        $this->assertEquals($masterWeight, $parsed->getMasterWeight());
        $this->assertEquals($highThreshold, $parsed->getHighThreshold());
        $this->assertEquals($mediumThreshold, $parsed->getMediumThreshold());
        $this->assertEquals($lowThreshold, $parsed->getLowThreshold());
        $this->assertEquals($homeDomain, $parsed->getHomeDomain());
    }
}
