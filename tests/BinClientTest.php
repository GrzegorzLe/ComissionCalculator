<?php
namespace Tests;

use PHPUnit\Framework\TestCase;
use App\Client\BinClient;

class BinClientTest extends TestCase
{
//    private $config = require __DIR__ . "/../config/config.php";
    private BinClient $binClient;

    protected function setup( ): void
    {
        $config = include __DIR__ . "/../config/config.php";
        $this->binClient = new BinClient( $config );
    }

    public function testCorrectBin( )
    {
        $this->assertTrue( $this->binClient->isEuBin( "45717360" ) );
        $this->assertFalse( $this->binClient->isEuBin( "45417360" ) );
    }

    public function testIncorrectBin( )
    {
        $this->assertFalse( $this->binClient->isEuBin( "12345417360123" ) );
    }
}
