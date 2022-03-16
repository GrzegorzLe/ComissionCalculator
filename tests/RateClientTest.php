<?php
use PHPUnit\Framework\TestCase;
use App\Client\RateClient;

class RateClientTest extends TestCase
{
    private RateClient $rateClient;

    protected function setup( ): void
    {
        $config = include __DIR__ . "/../config/config.php";
        $this->rateClient = new RateClient( $config );
    }

    public function testCorrectCurrency( )
    {
        $this->assertEquals( 1, $this->rateClient->getExchangeRate( "EUR" ) );
        $this->assertGreaterThan( 100, $this->rateClient->getExchangeRate( "JPY" ) );
        $this->assertLessThan( 1, $this->rateClient->getExchangeRate( "GBP" ) );
    }

    public function testIncorrectCurrency( )
    {
        $this->assertEquals( 1, $this->rateClient->getExchangeRate( "ZL" ) );
    }
}
