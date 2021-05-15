<?php


namespace Tests\Integration;


use Tests\Util\IntegrationTest;

class ChangeTrustOpTest extends IntegrationTest
{
    /**
     * @group requires-integrationnet
     * @throws \OneCoin\StellarSdk\Horizon\Exception\HorizonException
     * @throws \ErrorException
     */
    public function testAddAndRemoveTrust()
    {
        $keypair = $this->getRandomFundedKeypair();
        $usdAsset = $this->fixtureAssets['usd'];

        $this->horizonServer->buildTransaction($keypair)
            ->addChangeTrustOp($usdAsset, 4294967297) // 2^32 + 1
            ->submit($keypair);

        // Verify trustline is added
        $account = $this->horizonServer->getAccount($keypair);

        $balanceAmount = $account->getCustomAssetBalance($usdAsset);

        $this->assertEquals(4294967297, $balanceAmount->getLimit()->getScaledValue());

        // Remove trustline by setting to 0
        $this->horizonServer->buildTransaction($keypair)
            ->addChangeTrustOp($usdAsset, 0)
            ->submit($keypair);

        $account = $this->horizonServer->getAccount($keypair);
        $balanceAmount = $account->getCustomAssetBalance($usdAsset);
        // Should now be null
        $this->assertNull($balanceAmount);
    }
}
