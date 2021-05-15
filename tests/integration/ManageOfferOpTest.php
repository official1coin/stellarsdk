<?php


namespace OneCoin\StellarSdk\Test\Integration;


use OneCoin\StellarSdk\Test\Util\IntegrationTest;
use OneCoin\StellarSdk\XdrModel\Asset;
use OneCoin\StellarSdk\XdrModel\Operation\ManageOfferOp;
use OneCoin\StellarSdk\XdrModel\Price;

class ManageOfferOpTest extends IntegrationTest
{
    /**
     * @group requires-integrationnet
     * @throws \OneCoin\StellarSdk\Horizon\Exception\HorizonException
     * @throws \ErrorException
     */
    public function testSubmitOffer()
    {
        $usdBankKeypair = $this->fixtureAccounts['usdBankKeypair'];
        $usdAsset = $this->fixtureAssets['usd'];

        // Sell 100 USDTEST for 0.02 XLM
        $xlmPrice = new Price(2, 100);
        $offerOp = new ManageOfferOp($usdAsset, Asset::newNativeAsset(), 100, $xlmPrice);

        $response = $this->horizonServer->buildTransaction($usdBankKeypair)
            ->addOperation($offerOp)
            ->submit($usdBankKeypair);

        // todo: add support for offers and verify here
        // todo: verify canceling an offer
    }
}
