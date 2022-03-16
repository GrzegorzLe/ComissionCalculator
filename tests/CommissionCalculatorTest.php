<?php
namespace Tests;

use PHPUnit\Framework\TestCase;
use GuzzleHttp\Handler\MockHandler;
use GuzzleHttp\HandlerStack;
use GuzzleHttp\Psr7\Response;
use App\CommissionCalculator;

class CommissionCalculatorTest extends TestCase
{
    private CommissionCalculator $commissionCalculator;

    protected function setup( ): void
    {
        $config = include __DIR__ . "/../config/config.php";
        $config2 = $config;
        $mock = new MockHandler( [
            new Response( 200, [ ], file_get_contents( __DIR__ . "/../data/exchangeratemock.json" ) ),
        ] );
        $handlerStack = HandlerStack::create( $mock );
        $config[ 'handler' ] = $handlerStack;
        $this->commissionCalculator = new CommissionCalculator( $config2, $config );
    }

    public function testEuBinEurCurrency( )
    {
        $this->assertEquals( $this->commissionCalculator->calculate( [
            'amount' => 100.00,
            'currency' => 'EUR',
            'bin' => '45717360',
            ] ), 1.0 );
    }

    public function testEuBinUsdCurrency( )
    {
        $this->assertEquals( $this->commissionCalculator->calculate( [
            'amount' => 50.00,
            'currency' => 'USD',
            'bin' => '516793',
            ] ), 0.46 );
    }

    public function testNonEuBinEurCurrency( )
    {
        $this->assertEquals( $this->commissionCalculator->calculate( [
            'amount' => 100.00,
            'currency' => 'EUR',
            'bin' => '4745030',
            ] ), 2.0 );
    }

    public function testNonEuBinJpyCurrency( )
    {
        $this->assertEquals( $this->commissionCalculator->calculate( [
            'amount' => 10000.00,
            'currency' => 'JPY',
            'bin' => '4745030',
            ] ), 1.55 );
    }
}
