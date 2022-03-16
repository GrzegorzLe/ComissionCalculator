<?php
//require __DIR__ . '/../../vendor/autoload.php';

namespace App\Client;

use GuzzleHttp\Client;

class BinClient extends Client
{
    private const EU_COUNTRYCODES = [
        "AT", "BE", "BG", "CY", "CZ", "DE", "DK", "EE", "EL",
        "ES", "FI", "FR", "GR", "HR", "HU", "IE", "IT", "LT", "LU", "LV",
        "MT", "NL", "PL", "PT", "RO", "SE", "SI", "SK",
    ];

    public function __construct( $config = [ ] )
    {
        $config[ 'base_uri' ] = $config[ 'binlist_uri' ];
        parent::__construct( $config );
    }

    /*
     * @TODO implement proper handling of incorrect BINs/api errors
     */
    public function isEuBin( $bin )
    {
        try
        {
            $countrycode = \json_decode( parent::GET( $bin )->getBody( ) )->country->alpha2;
        }
        catch ( \Exception $e )
        {
            return false;
        }
        return \in_array( \strtoupper( $countrycode ), SELF::EU_COUNTRYCODES );
    }
}
