<?php


namespace Tests\Integration;


use OneCoin\StellarSdk\Server;
use Tests\Util\IntegrationTest;


class ServerTest extends IntegrationTest
{
    /**
     * @group requires-integrationnet
     */
    public function testConnectToCustomNetwork()
    {
        $server = Server::customNet($this->horizonBaseUrl, $this->networkPassword);

        // Verify one of the fixture accounts can be retrieved
        $account = $server->getAccount($this->fixtureAccounts['basic1']->getPublicKey());

        // Account should have at least one balance
        $this->assertNotEmpty($account->getBalances());
    }
}
