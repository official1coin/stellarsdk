<?php

namespace Tests\Unit\Transaction;


use phpseclib3\Math\BigInteger;
use PHPUnit\Framework\TestCase;
use OneCoin\StellarSdk\Keypair;
use OneCoin\StellarSdk\Transaction\Transaction;
use OneCoin\StellarSdk\Transaction\TransactionBuilder;
use OneCoin\StellarSdk\Util\Debug;
use OneCoin\StellarSdk\Xdr\XdrBuffer;
use OneCoin\StellarSdk\XdrModel\AccountId;
use OneCoin\StellarSdk\XdrModel\Operation\CreateAccountOp;

class TransactionTest extends TestCase
{
    public function testFromXdr()
    {
        $sourceKeypair = Keypair::newFromRandom();

        // Build transaction
        $sourceModel = new TransactionBuilder($sourceKeypair);
        $sourceModel->setSequenceNumber(new BigInteger(123));

        $createAccountOp = new CreateAccountOp(new AccountId(Keypair::newFromRandom()), 100);
        $sourceModel->addOperation($createAccountOp);

        $sourceModel->setLowerTimebound(new \DateTime('2018-01-01 00:00:00'));
        $sourceModel->setUpperTimebound(new \DateTime('2018-12-31 00:00:00'));
        $sourceModel->setTextMemo('test memo');

        // Encode and then parse the resulting XDR
        $parsed = Transaction::fromXdr(new XdrBuffer($sourceModel->toXdr()));
        $parsedOps = $parsed->getOperations();

        $this->assertCount(1, $parsedOps);

        $this->assertEquals($sourceKeypair->getAccountId(), $parsed->getSourceAccountId()->getAccountIdString());
        $this->assertEquals('test memo', $parsed->getMemo()->getValue());
    }
}
