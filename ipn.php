<?php
use PayPal\IPN\PPIPNMessage;

if(file_exists(dirname(__FILE__) .'/vendor/autoload.php')) {
  require 'vendor/autoload.php';
}

// if(file_exists(dirname(__FILE__) .'/db.php')) {
//   require 'db.php';
// }

$config = array(
  "mode" => "sandbox",
);

$fileName = dirname(__FILE__) .'/logs/ipn-' . date('Y-m-d_his') . '.txt';
$ipnMessage = new PPIPNMessage(null, $config);
$response = $ipnMessage->getRawData();

// Log IPN Response
foreach($response as $key => $value) {
	file_put_contents($fileName, "IPN: $key => $value\n", FILE_APPEND | LOCK_EX);
}

// Check if IPN is Valid
if($ipnMessage->validate()) {
  file_put_contents($fileName, "\nSuccess: Got valid IPN data\n", FILE_APPEND | LOCK_EX);

  // Check if Paymen was Completed, and that we are not in Test Mode
  if (strtolower($response['payment_status']) === 'completed') {
    // @TODO: Fire of LOB API Call & add $response['test_ipn'] !== '1' check
    file_put_contents($fileName, "\nPayment Received. Fire LOB API Call\n", FILE_APPEND | LOCK_EX);
  } else {
    file_put_contents($fileName, "\nPayment Not Received, Skip LOB API Call.\n", FILE_APPEND | LOCK_EX);
  }
} else {
	file_put_contents($fileName, "\nError: Got invalid IPN data\n", FILE_APPEND | LOCK_EX);
}
