<?php

/**
 * makes sure transactions data are converted in Pounds and display them
 * @uses Application_Model_CurrencyConverter 
 * @uses Application_Model_CurrencyWebservice
 */
 
class Application_Model_Merchant
{
	public $merchantId;
	
	//the mapp between currency name and symbol
	public $currencyMapp;
	
	
	public function __construct()
	{
		$this->currencyMapp = ['£'=>'GBP', '$'=>'USD','€'=>'EUR'];
	}
	
	/**
	 * returns transaction data based on merchant Id
	 * @param $merchantId int
	 * @return $transactionDataArr Array of transactions object
	 */
	public function getTransactions($merchantId)
    {
        $transactionModel = new Application_Model_TransactionTable();
		$transactionDataArr  = $transactionModel->getTransactionsByMerchantID($merchantId);
		
		$transactionDataArr = $this->applyCurrencyConverter($transactionDataArr, 'GBP');
		
		return $transactionDataArr;
    }
	
	/**
	 * convert amount in Pounds where applicable
	 * @param $transactionData Array
	 * @param $poundCurrency String the Pounds currency
	 * @return $transactionData Array of converted transactions in Pounds
	 */
	public function applyCurrencyConverter(array $transactionData, $poundCurrency)
	{
		// check that the pounds is supporter by the currency Webservice
		if (!empty($transactionData) && $this->isValid($poundCurrency)) {
			
			$currencyConverterObj = $this->getCurrencyConverter();
		
			foreach($transactionData as &$transObj)
			{
				//seperate the amount and the currency sign
				$amount_arr = $this->getAmountAndCurrency($transObj->value);
				
				if ($this->currencyMapp[$amount_arr['currency']] != $poundCurrency){
					//passe the amount and the currency rate name
					$amount_arr['amount'] 	= $currencyConverterObj->convert(number_format($amount_arr['amount'],2),$this->currencyMapp[$amount_arr['currency']]);
					
					$transObj->value  		= '£'.$amount_arr['amount'];
				}
			}
		}
		
		//return an array of transactions object
		return $transactionData;
	}
	
	/**
	 * load currencyConverter Object
	 * @return Application_Model_CurrencyConverter
	 */
	public function getCurrencyConverter()
	{
		$currencyWebservice = new Application_Model_CurrencyWebservice();
			
		$currencyConverter = new Application_Model_CurrencyConverter($currencyWebservice);
		
		return $currencyConverter;
		
	}
	
	/**
	 * seperates amount from currency
	 * @param $value float
	 * @return Array with the amount and the currency symbol
	 */
	function getAmountAndCurrency($value){
		
	     $amountPattern		="/[0-9\.]+/";
	     $currencyPattern 	="/[£\$€]+/";
	
	     preg_match($amountPattern, $value, $matches);
	     $amount = floatval($matches[0]);
	
	     preg_match($currencyPattern, $value, $matches);
	     $currency = $matches[0];
		 
		 return ['amount'=>$amount, 'currency' => $currency];
   }
	
	/**
	 * check the validite of the currency
	 * @param $poundCurrency String - currency name
	 * @return bool
	 */
	public function isValid($poundCurrency)
	{
		if (strlen($poundCurrency) > 0 && in_array($poundCurrency,Application_Model_CurrencyWebservice::validCurrencies())) {
			return true;
		}
		
		return false;
	}
}
