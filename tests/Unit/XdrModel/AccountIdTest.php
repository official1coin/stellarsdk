<?php


namespace OneCoin\StellarSdk\Test\Unit\XdrModel;


use PHPUnit\Framework\TestCase;
use OneCoin\StellarSdk\Xdr\XdrBuffer;
use OneCoin\StellarSdk\XdrModel\AccountId;

class AccountIdTest extends TestCase
{
    public function testAccountIdFromXdr()
    {
        $accountId = 'GAIL4CFBWB4PAQKXAKXEY5Z3PQMI5SHP2WCXX7AE66MNOKFXJ5WHWG6M';
        $source = new AccountId($accountId);

        $decoded = AccountId::fromXdr(new XdrBuffer($source->toXdr()));

        $this->assertEquals(AccountId::KEY_TYPE_ED25519, $decoded->getKeyType());
        $this->assertEquals($accountId, $decoded->getAccountIdString());
    }
}
