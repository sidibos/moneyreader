<?php
class Application_Model_CurrencyWebserviceTest extends PHPUnit_Framework_TestCase
{
	public function testCurrencyWebserviceIsReturningRates()
	{
		$currencyWebserviceModel 	= new Application_Model_CurrencyWebservice();
		$ratesArr 					=  $currencyWebserviceModel->getExchangeRatesFor('GBP');
		
		$this->assertNotEmpty($ratesArr);
	}
	
	public function testCurrencyWebserviceIsReturningTheRightRate()
	{
		$poundsToEuroRate = 1.28;
		
		$currencyWebserviceModel 	= new Application_Model_CurrencyWebservice();
		$ratesArr 					=  $currencyWebserviceModel->getExchangeRatesFor('GBP');
		
		$this->assertEquals($poundsToEuroRate,$ratesArr['EUR']);
	}
}
