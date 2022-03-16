<?php
namespace App;

use App\Client\BinClient;
use App\Client\RateClient;

class CommissionCalculator
{
    private float $amount;
    private string $bin;
    private string $currency;
    private BinClient $binClient;
    private RateClient $rateClient;

    public function __construct( $binConfig, $rateConfig = null )
    {
        if ( $rateConfig === null )
            $rateConfig = $binConfig;
        $this->binClient = new BinClient( $binConfig );
        $this->rateClient = new RateClient( $rateConfig );

        return $this;
    }

    public function calculate( $entry, $precision = 2 )
    {
        return static::roundUp( $entry[ 'amount' ] / $this->rateClient->getExchangeRate( $entry[ 'currency' ] ) *
            $this->getCommissionRate( $entry[ 'bin' ] ), $precision );
    }

    private function getCommissionRate( $bin )
    {
        $commissionRate = 0.02;
        if ( $this->binClient->isEuBin( $bin ) )
            $commissionRate = 0.01;
        return $commissionRate;
    }

    private static function roundUp( $amount, $precision = 0 )
    {
        $multiplier = pow( 10, $precision );
        return ceil( $amount * $multiplier ) / $multiplier;
    }
}