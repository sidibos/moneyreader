<?php
class Application_Model_MerchantTest extends PHPUnit_Framework_TestCase
{
	/*public function setUp()
    {
        $this->bootstrap = new Zend_Application(APPLICATION_ENV, APPLICATION_PATH . '/configs/application.ini');
        parent::setUp();
    }*/
	
	public function testGetCurrencyConverterIsReturningConverterInstance()
	{
		$merchantModel 			= new Application_Model_Merchant();
		$currencyConverterObj 	= $merchantModel->getCurrencyConverter();
		
		$this->assertInstanceOf('Application_Model_CurrencyConverter',$currencyConverterObj);
	}
	
	public function testAmountAndCurrencyAreBeingExtractedFromValue()
	{
		$amount 		= '£50.00';
		$merchantModel 	= new Application_Model_Merchant();
		$amountArr		= $merchantModel->getAmountAndCurrency($amount);
		
		$expected 		= $amountArr['currency'].number_format($amountArr['amount'],2);
		
		$this->assertSame($amount,$expected);
		
	}
	
	public function testFloatValueIsBeingSeperatedFine()
	{
		$amount 		= '£50.42';
		$floatValue 	= 50.42;
		$merchantModel 	= new Application_Model_Merchant();
		$amountArr		= $merchantModel->getAmountAndCurrency($amount);
		$resultFloat 	= number_format($amountArr['amount'],2);
		
		$this->assertEquals($floatValue,$resultFloat);
	}
	
	public function testMerchantIsGettingTheTransactionsData()
	{
		$merchantModel 			= new Application_Model_Merchant();
		$transactionsDataArr 	= $merchantModel->getTransactions(2);
		
		$this->assertGreaterThan(0,count($transactionsDataArr));
	}
	
	public function testMerchantNotInCsvFileDoNotReturnData()
	{
		$merchantModel 			= new Application_Model_Merchant();
		$transactionsDataArr 	= $merchantModel->getTransactions(3);
		
		$this->assertEquals(0,count($transactionsDataArr));
		
	}
}
