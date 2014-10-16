<?php
define('FILE_PATH',APPLICATION_PATH.'/../');

/*
 * transaction data source - process and return transactions from source file
 */
class Application_Model_TransactionTable
{
	/**
	 * returns transactions based on merchant Id
	 * @param $merchantId int
	 * @return $transactionData Array - returns array of transaction Object
	 */
	public function getTransactionsByMerchantID($merchantId)
	{
		$data_arr = $this->getData('data.csv');
		
		$transactionData = [];
		
		foreach($data_arr as $transDataArr){
			if ($transDataArr['merchant'] == $merchantId) {
				$transactionObj 			= new Application_Model_Entity_Transaction();
				$transactionObj->merchantId = $transDataArr['merchant'];
				$transactionObj->date 		= $transDataArr['date'];
				$transactionObj->value		= $transDataArr['value'];
				
				$transactionData[] = $transactionObj;
			}
		}
		
		return $transactionData;
	}
	
	/**
	 * process source file and returns transactions data
	 * @param $filename String - the name of the file
	 * @return $dataArr Array - transactions data
	 */
	public function getData($filename)
	{
		$dataArr = [];
		$header   = [];
		
		if (file_exists(FILE_PATH.$filename)) {
			
			$handler = fopen(FILE_PATH.$filename, 'r');
			
			$i = 0;
			while ( ($data = fgetcsv($handler,1000,';')) !== false) {
				
				if ($i == 0) {
					$header = $data;
					$i++;
					continue;
				}
				
				$dataArr[] = array_combine($header,$data);
			}
			
			fclose($handler);
		} else {
			throw new Exception("File $filename doesn\'t exist.");
		}
		
		return $dataArr;
	}
}
