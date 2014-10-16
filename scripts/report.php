<?php
require_once realpath(dirname(__FILE__)).'/bootstrap.php';

try {
	$getopt = new Zend_Console_Getopt(array(
                'merchantId|m=i' => 'Merchant Id',
            ));
    $getopt->parse();
	$merchantId = $getopt->getOption('m');
} catch (Zend_Console_Getopt_Exception $e) {
    echo 'Error - Merchant Id should be an integer.';
	exit;
}

echo PHP_EOL;
$merchantModel = new Application_Model_Merchant();

echo 'List of Transactions for Merchant ID - '.$merchantId.PHP_EOL.PHP_EOL;

foreach($merchantModel->getTransactions($merchantId) as $transactionObj){
	echo $transactionObj->merchantId.'-'.$transactionObj->date.'-'.$transactionObj->value.PHP_EOL;
}
echo PHP_EOL;