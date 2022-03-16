<?php
//require __DIR__ . '/../../vendor/autoload.php';

namespace App\Client;

use GuzzleHttp\Client;

class RateClient extends Client
{
    public function __construct( $config = [ ] )
    {
        $config[ 'base_uri' ] = $config[ 'exchangerate_uri' ];
        $config[ 'query' ] = [ 'access_key' => $config[ 'exchangerate_key' ] ];
        parent::__construct( $config );
    }

    /*
     * @TODO implement proper handling of missing currency
     * @TODO implement proper handling of api errors
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
