<?php


namespace OneCoin\StellarSdk\Test\Unit\XdrModel\Operation;


use PHPUnit\Framework\TestCase;
use OneCoin\StellarSdk\Keypair;
use OneCoin\StellarSdk\Xdr\XdrBuffer;
use OneCoin\StellarSdk\XdrModel\Asset;
use OneCoin\StellarSdk\XdrModel\Operation\ManageDataOp;
use OneCoin\StellarSdk\XdrModel\Operation\Operation;

class ManageDataOpTest extends TestCase
{
    public function testFromXdr()
    {
        $sourceOp = new ManageDataOp('testkey', 'testvalue');

        /** @var ManageDataOp $parsed */
        $parsed = Operation::fromXdr(new XdrBuffer($sourceOp->toXdr()));

        $this->assertTrue($parsed instanceof ManageDataOp);

        $this->assertEquals('testkey', $parsed->getKey());
        $this->assertEquals('testvalue', $parsed->getValue());
    }
}
