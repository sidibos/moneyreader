<?php

class Application_Model_TransactionTableTest extends PHPUnit_Framework_TestCase
{
	public function testTransactionsFileExists()
	{
		$this->assertFileExists(APPLICATION_PATH.'/../data.csv');
	}
	
	public function testTransactionIsReturningData()
	{
		$transactionModel 	= new Application_Model_TransactionTable();
		$transactionDataArr = $transactionModel->getData('data.csv');
		
		$this->assertGreaterThan(0,count($transactionDataArr));
	}
	
	public function testTransactionIsReturningDataByMerchantId()
	{
		$transactionModel 	= new Application_Model_TransactionTable();
		$transctionData_arr = $transactionModel->getTransactionsByMerchantID(1);
		$this->assertEquals(count($transctionData_arr), 4);
	}
	
	/**
	* @expectedException Exception
	*
	*/
	public function testGetDataIsThrowingExceptionIfFileDoNotExists()
	{
		$transactionModel 	= new Application_Model_TransactionTable();
		$data = $transactionModel->getData('NotFile.csv');
	}
}