<?
require __DIR__ . '/../vendor/autoload.php';

use App\CommissionCalculator;

/* read config */
$config = require_once __DIR__ . '/../config/config.php';

/* determine input file */
if ( isset( $argc ) && $argc > 1 )
    $fileName = $argv[1];
else
    $filename = "/app/data/input.txt";

/* read the input file contents */
$fileContents = json_decode( "[" . str_replace( "\n", ",\n", file_get_contents( $filename ) ) . "{}]", true );
/* remove last empty item */
array_pop( $fileContents );

/* initiate commission calculator */
$commissionCalculator = new CommissionCalculator( $config );

/* calculate commission for each entry */
foreach( $fileContents as $entry )
{
    echo $commissionCalculator->calculate( $entry, 2 ) . "\n";
}
