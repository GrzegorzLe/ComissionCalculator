<?php
//require __DIR__ . '/../../vendor/autoload.php';

namespace App\Client;

use GuzzleHttp\Client;

/**
 * API client fetching exchange rates
 */
class RateClient extends Client
{
    /**
     * maps config values to guzzle config parameters
     *
     * @param array config
     */
    public function __construct( $config = [ ] )
    {
        $config[ 'base_uri' ] = $config[ 'exchangerate_uri' ];
        $config[ 'query' ] = [ 'access_key' => $config[ 'exchangerate_key' ] ];
        parent::__construct( $config );
    }

    /**
     * fetches EUR exchange rate for given currency
     *
     * @TODO implement proper handling of missing currency
     * @TODO implement proper handling of api errors
     *
     * @param string currency
     */
    public function getExchangeRate( $currency )
    {
        $rate = 1;
        try
        {
            if ( $currency != 'EUR' )
                $rate = @json_decode( parent::GET( '' )->getBody( ) )->rates->$currency;
            if ( !isset( $rate ) )
                $rate = 1;
        }
        catch ( \Exception $e )
        { }

        return $rate;
    }
}
