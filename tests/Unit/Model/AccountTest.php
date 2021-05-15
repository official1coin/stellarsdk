<?php


namespace OneCoin\StellarSdk\Test\Unit\Model;


use PHPUnit\Framework\TestCase;
use OneCoin\StellarSdk\Model\Account;

class AccountTest extends TestCase
{
    public function testIsValidAccount()
    {
        $this->assertTrue(Account::isValidAccount('GDRXE2BQUC3AZNPVFSCEZ76NJ3WWL25FYFK6RGZGIEKWE4SOOHSUJUJ6'));

        $this->assertFalse(Account::isValidAccount(null));
        $this->assertFalse(Account::isValidAccount('G123'));
    }
}
