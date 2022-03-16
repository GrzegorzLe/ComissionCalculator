<?
require __DIR__ . '/../vendor/autoload.php';

use App/CommissionCalculator;

$config = require_once __DIR__ . '/../config/config.php';

if ( isset( $argc ) && $argc > 1 )
    $fileName = $argv[1];
else
    $filename = "input.txt";

$fileContents = json_decode( "[" . str_replace( "\n", ",\n", file_get_contents( $filename ) ) . "{}]", true );
array_pop( $fileContents );

$commissionCalculator = new CommissionCalculator( $config );

foreach( $fileContents as $entry )
{
    echo $commissionCalculator->calculate( $entry, 2 ) . "\n";
}
