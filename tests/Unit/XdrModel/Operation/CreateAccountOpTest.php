<?php


namespace OneCoin\StellarSdk\Test\Unit\XdrModel\Operation;


use PHPUnit\Framework\TestCase;
use OneCoin\StellarSdk\Keypair;
use OneCoin\StellarSdk\Xdr\XdrBuffer;
use OneCoin\StellarSdk\XdrModel\AccountId;
use OneCoin\StellarSdk\XdrModel\Operation\CreateAccountOp;
use OneCoin\StellarSdk\XdrModel\Operation\Operation;

class CreateAccountOpTest extends TestCase
{
    public function testFromXdr()
    {
        $newAccountKeypair = Keypair::newFromRandom();
        $sourceAccountKeypair = Keypair::newFromRandom();

        $newAccountId = new AccountId($newAccountKeypair->getAccountId());
        $source = new CreateAccountOp($newAccountId, 1000, $sourceAccountKeypair);

        /** @var CreateAccountOp $parsed */
        $parsed = Operation::fromXdr(new XdrBuffer($source->toXdr()));

        $this->assertTrue($parsed instanceof CreateAccountOp);
        $this->assertEquals($sourceAccountKeypair->getAccountId(), $parsed->getSourceAccount()->getAccountIdString());

        $this->assertEquals($source->getNewAccount()->getAccountIdString(), $parsed->getNewAccount()->getAccountIdString());
        $this->assertEquals($source->getStartingBalance()->getScaledValue(), $parsed->getStartingBalance()->getScaledValue());
    }
}
