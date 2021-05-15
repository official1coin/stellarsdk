<?php


namespace OneCoin\StellarSdk\Signing;

use OneCoin\StellarSdk\Transaction\TransactionBuilder;
use OneCoin\StellarSdk\XdrModel\DecoratedSignature;

interface SigningInterface
{
    /**
     * Returns a DecoratedSignature for the given TransactionBuilder
     *
     * @param TransactionBuilder $builder
     * @return DecoratedSignature
     */
    public function signTransaction(TransactionBuilder $builder);
}
