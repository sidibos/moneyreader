<?php

// Set up the testing environment  
class Application_Model_CurrencyConverterTest extends PHPUnit_Framework_TestCase
{
	
	public function testCurrencyConverterIsConvertingWithCorrectRate()
	{
		$amount 		= 128; //assert 128 Euro is equal 100 pound
		$expectedAmount = 99.84; //in pounds
		
		$currencyWebserviceModel 	= new Application_Model_CurrencyWebservice();
		$currencyConverterModel  	= new Application_Model_CurrencyConverter($currencyWebserviceModel);
		$convertedAmount 			= $currencyConverterModel->convert($amount, 'EUR');
		
		$this->assertEquals($expectedAmount,$convertedAmount);
		
	}
}