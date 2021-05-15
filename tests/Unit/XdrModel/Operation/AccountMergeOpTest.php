<?php


namespace Tests\Unit\XdrModel\Operation;


use PHPUnit\Framework\TestCase;
use OneCoin\StellarSdk\Keypair;
use OneCoin\StellarSdk\Xdr\XdrBuffer;
use OneCoin\StellarSdk\XdrModel\Operation\AccountMergeOp;
use OneCoin\StellarSdk\XdrModel\Operation\Operation;

class AccountMergeOpTest extends TestCase
{
    public function testFromXdr()
    {
        $source = new AccountMergeOp(Keypair::newFromRandom());

        /** @var AccountMergeOp $parsed */
        $parsed = Operation::fromXdr(new XdrBuffer($source->toXdr()));

        $this->assertTrue($parsed instanceof AccountMergeOp);
        $this->assertEquals($source->getDestination()->getAccountIdString(), $parsed->getDestination()->getAccountIdString());
    }
}
