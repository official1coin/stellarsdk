<?php


namespace Tests\Integration;


use Tests\Util\IntegrationTest;

class AccountMergeOpTest extends IntegrationTest
{
    /**
     * @group requires-integrationnet
     * @throws \OneCoin\StellarSdk\Horizon\Exception\HorizonException
     * @throws \ErrorException
     */
    public function testAccountMerge()
    {
        $mergeFrom = $this->getRandomFundedKeypair();
        $mergeTo = $this->getRandomFundedKeypair();


        $this->horizonServer->buildTransaction($mergeFrom)
            ->addMergeOperation($mergeTo)
            ->submit($mergeFrom);

        // Verify mergeFrom account no longer exists
        $mergeFromAccount = $this->horizonServer->getAccount($mergeFrom);
        $this->assertNull($mergeFromAccount);

        $mergeToAccountBalance = $this->horizonServer
            ->getAccount($mergeTo)
            ->getNativeBalance();

        // Verify mergeToAccount has double balance (minus fees)
        $this->assertEquals(19999.99999, $mergeToAccountBalance);
    }
}
