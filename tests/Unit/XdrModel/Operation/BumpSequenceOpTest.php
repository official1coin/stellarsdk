<?php


namespace Tests\Unit\XdrModel\Operation;


use phpseclib3\Math\BigInteger;
use PHPUnit\Framework\TestCase;
use OneCoin\StellarSdk\Xdr\XdrBuffer;
use OneCoin\StellarSdk\XdrModel\Operation\BumpSequenceOp;
use OneCoin\StellarSdk\XdrModel\Operation\Operation;

class BumpSequenceOpTest extends TestCase
{
    public function testFromXdr()
    {
        $source = new BumpSequenceOp(new BigInteger('1234567890'));

        /** @var BumpSequenceOp $parsed */
        $parsed = Operation::fromXdr(new XdrBuffer($source->toXdr()));

        $this->assertTrue($parsed instanceof BumpSequenceOp);
        $this->assertEquals($source->getBumpTo()->toString(), $parsed->getBumpTo()->toString());
    }
}
