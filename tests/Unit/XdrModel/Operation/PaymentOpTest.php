<?php


namespace OneCoin\StellarSdk\Test\Unit\XdrModel\Operation;


use PHPUnit\Framework\TestCase;
use OneCoin\StellarSdk\Keypair;
use OneCoin\StellarSdk\Xdr\XdrBuffer;
use OneCoin\StellarSdk\XdrModel\AccountId;
use OneCoin\StellarSdk\XdrModel\Asset;
use OneCoin\StellarSdk\XdrModel\Operation\AccountMergeOp;
use OneCoin\StellarSdk\XdrModel\Operation\Operation;
use OneCoin\StellarSdk\XdrModel\Operation\PaymentOp;

class PaymentOpTest extends TestCase
{
    public function testFromXdr()
    {
        $sourceOp = new PaymentOp();
        $sourceOp->setDestination(new AccountId(Keypair::newFromRandom()->getAccountId()));
        $sourceOp->setAmount(100);
        $sourceOp->setAsset(Asset::newNativeAsset());


        /** @var PaymentOp $parsed */
        $parsed = Operation::fromXdr(new XdrBuffer($sourceOp->toXdr()));

        $this->assertTrue($parsed instanceof PaymentOp);
        $this->assertEquals($sourceOp->getDestination()->getAccountIdString(), $parsed->getDestination()->getAccountIdString());
        $this->assertEquals($sourceOp->getAmount()->getScaledValue(), $parsed->getAmount()->getScaledValue());
        $this->assertEquals($sourceOp->getAsset()->getType(), $parsed->getAsset()->getType());
    }
}
