<?php


namespace OneCoin\StellarSdk\Test\Unit\XdrModel\Operation;


use PHPUnit\Framework\TestCase;
use OneCoin\StellarSdk\Keypair;
use OneCoin\StellarSdk\Xdr\XdrBuffer;
use OneCoin\StellarSdk\XdrModel\Asset;
use OneCoin\StellarSdk\XdrModel\Operation\InflationOp;
use OneCoin\StellarSdk\XdrModel\Operation\Operation;

class InflationOpTest extends TestCase
{
    public function testFromXdr()
    {
        $sourceOp = new InflationOp();

        /** @var InflationOpTest $parsed */
        $parsed = Operation::fromXdr(new XdrBuffer($sourceOp->toXdr()));

        $this->assertTrue($parsed instanceof InflationOp);
    }
}
