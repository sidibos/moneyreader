<?php

/**
 * currency converter - will convert EUR and USD in GBP
 * 
 * @uses Application_Model_CurrencyWebservice
 *
 */
class Application_Model_CurrencyConverter
{
	protected $curencyWebservice;
	
	/**
	 * @param $currencyWebservice Application_Model_CurrencyWebservice
	 */
    public function __construct(Application_Model_CurrencyWebservice $currencyWebservice)
	{
		$this->curencyWebservice = $currencyWebservice;
	}
	
	/**
	 * convert the $amount and the given $currency into GBP - the pound 
	 * @param $amount int - amount to convert
	 * @param $currency String - the amount current currency
	 * @return $value converted amount in Pounds
	 */
    public function convert($amount, $currency)
    {
    	$rates_arr = $this->curencyWebservice->getExchangeRatesFor($currency);
			
		$rate 		= $rates_arr['GBP']; // get the exchange rate for this currency to pounds
		return number_format($amount*$rate,2);
    }
}