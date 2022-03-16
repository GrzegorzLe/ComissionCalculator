<?php
namespace App;

use App\Client\BinClient;
use App\Client\RateClient;

/*
 * Calculates commission based on bin number and current exchange rate
 * Commission is calculated in EUR currency
 */
class CommissionCalculator
{
    private float $amount;
    private string $bin;
    private string $currency;
    private BinClient $binClient;
    private RateClient $rateClient;

    /**
     * initaializes bin and rate clients
     *
     * @param array binConfig configuration values for bin client
     * @param array rateConfig configuration values for rate client if different from bin client config
     *
     * @return CommissionCalculator
     */
    public function __construct( array $binConfig, array $rateConfig = null )
    {
        if ( $rateConfig === null )
            $rateConfig = $binConfig;
        $this->binClient = new BinClient( $binConfig );
        $this->rateClient = new RateClient( $rateConfig );

        return $this;
    }

    /**
     * calculates commission based on bin number and current exchange rate
     * returns commission with given decimal precision
     *
     * @param array entry bin, currency and amount data
     * @param int precision specifies result decimal precision
     *
     * @return string
     */
    public function calculate( $entry, int $precision = 2 ): string
    {
        return static::roundUp( $entry[ 'amount' ] / $this->rateClient->getExchangeRate( $entry[ 'currency' ] ) *
            $this->getCommissionRate( $entry[ 'bin' ] ), $precision );
    }

    /**
     * @param string bin bin number
     *
     * @return string
     */
    private function getCommissionRate( $bin ): string
    {
        $commissionRate = 0.02;
        if ( $this->binClient->isEuBin( $bin ) )
            $commissionRate = 0.01;
        return $commissionRate;
    }

    /**
     * @param string amount amount to be rounded up
     * @param int precision specifies result decimal precision
     */
    private static function roundUp( $amount, int $precision = 0 )
    {
        $multiplier = pow( 10, $precision );
        return ceil( $amount * $multiplier ) / $multiplier;
    }
}
