<?php


namespace Tests\Integration;


use Tests\Util\IntegrationTest;
use OneCoin\StellarSdk\Keypair;
use OneCoin\StellarSdk\XdrModel\Asset;
use OneCoin\StellarSdk\XdrModel\Operation\PathPaymentOp;

class PathPaymentOpTest extends IntegrationTest
{
    /**
     * Pays a merchant in JPY via a market maker that supports XLM -> JPY trades
     *
     * todo: integrate this with payment path discovery in Horizon
     *
     * @group requires-integrationnet
     * @throws \OneCoin\StellarSdk\Horizon\Exception\HorizonException
     * @throws \ErrorException
     */
    public function testSingleStepPathPayment()
    {
        /** @var Keypair $sourceKeypair */
        $sourceKeypair = $this->fixtureAccounts['basic1'];
        $destinationKeypair = $this->fixtureAccounts['jpyMerchantKeypair'];

        $usdAsset = $this->fixtureAssets['usd'];
        $jpyAsset = $this->fixtureAssets['jpy'];

        $pathPayment = new PathPaymentOp(Asset::newNativeAsset(), 200, $destinationKeypair, $jpyAsset, 500);

        $pathPayment->addPath($usdAsset);

        $envelope = $this->horizonServer->buildTransaction($sourceKeypair)
            ->addOperation($pathPayment)
            ->getTransactionEnvelope();

        // todo: need additional fixtures to verify path payment
    }
}
