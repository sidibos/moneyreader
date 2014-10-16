<?php

/**
 * Dummy web service returning random exchange rates
 *
 */
 
class Application_Model_CurrencyWebservice
{
	//store all supported currencies exchange rates
	private $currencyRatesArr;
			
		
	public function __construct()
	{
		//these are the exchange rates for each currency 
		//e.g GBP will return pound rates to other currencies £1 = $1.62, £1 = €1.28
		$this->currencyRatesArr = [
				'GBP' => ['USD' => 1.62, 'EUR'=> 1.28],
				'EUR' => ['GBP' => 0.78, 'USD' => 1.27],
				'USD' => ['GBP' => 0.62, 'EUR' => 0.79],
		];
	}
		
    /**
     * return random value here for basic currencies like GBP USD EUR (simulates real API)
     * @param $currency - String
	 * @throws Exception if the currency is not supported
	 * @return Array - returns the exchange rates for this currency or thow exception
     */
    public function getExchangeRatesFor($currency)
    {
		if ($this->currencyExists($currency)) {
			//get the exchange rates for this currency
			return $this->currencyRatesArr[$currency];
		}
		
		throw new Exception('Currency doesn\'t exists');
    }
	
	/**
	 * check if the currency is supported by this service
	 * @param $currency String
	 * @return bool
	 */
	public function currencyExists($currency)
	{
		
		if (strlen($currency) > 0 && array_key_exists($currency, $this->currencyRatesArr)) {
			return true;
		}
		
		return false;
	}
	
	/**
	 * returns supported currencies
	 * @return Array - the currencies
	 */
	public static function validCurrencies()
	{
		return ['GBP','EUR','USD'];
	}
}