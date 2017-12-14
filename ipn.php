<?php
set_time_limit(0);

use PayPal\IPN\PPIPNMessage;

if(file_exists(dirname(__FILE__) .'/vendor/autoload.php')) {
  require dirname(__FILE__) . '/vendor/autoload.php';
}

if(file_exists(dirname(__FILE__) . '/config.php')) {
  require dirname(__FILE__) . '/config.php';
}

$config = array(
  "mode" => (TEST_MODE) ? 'SANDBOX' : 'LIVE',
);

$ipnMessage = new PPIPNMessage(null, $config);
$response = $ipnMessage->getRawData();

// Check if IPN is Valid
if($ipnMessage->validate()) {
  // Check if Paymen was Completed, and that we are not in Test Mode
  if (strtolower($response['payment_status']) === 'completed') {

    // Set IPN info
    $address_city = (isset($response['address_city'])) ? $response['address_city'] : NULL;
    $address_country_code = (isset($response['address_country_code'])) ? $response['address_country_code'] : NULL;
    $address_country = (isset($response['address_country'])) ? $response['address_country'] : NULL;
    $address_name = (isset($response['address_name'])) ? $response['address_name'] : NULL;
    $address_state = (isset($response['address_state'])) ? $response['address_state'] : NULL;
    $address_status = (isset($response['address_status'])) ? $response['address_status'] : NULL;
    $address_street = (isset($response['address_street'])) ? $response['address_street'] : NULL;
    $address_zip = (isset($response['address_zip'])) ? $response['address_zip'] : NULL;
    $custom = (isset($response['custom'])) ? $response['custom'] : NULL;
    $first_name = (isset($response['first_name'])) ? $response['first_name'] : NULL;
    $invoice = (isset($response['invoice'])) ? $response['invoice'] : NULL;
    $item_name = (isset($response['item_name'])) ? $response['item_name'] : NULL;
    $item_number = (isset($response['item_number'])) ? $response['item_number'] : NULL;
    $last_name = (isset($response['last_name'])) ? $response['last_name'] : NULL;
    $mc_currency = (isset($response['mc_currency'])) ? $response['mc_currency'] : NULL;
    $mc_fee = (isset($response['mc_fee'])) ? $response['mc_fee'] : NULL;
    $mc_gross = (isset($response['mc_gross'])) ? $response['mc_gross'] : NULL;
    $mc_handling = (isset($response['mc_handling'])) ? $response['mc_handling'] : NULL;
    $mc_shipping = (isset($response['mc_shipping'])) ? $response['mc_shipping'] : NULL;
    $notify_version = (isset($response['notify_version'])) ? $response['notify_version'] : NULL;
    $payer_email = (isset($response['payer_email'])) ? $response['payer_email'] : NULL;
    $payer_status = (isset($response['payer_status'])) ? $response['payer_status'] : NULL;
    $payment_date = (isset($response['payment_date'])) ? $response['payment_date'] : NULL;
    $payment_status = (isset($response['payment_status'])) ? $response['payment_status'] : NULL;
    $payment_type = (isset($response['payment_type'])) ? $response['payment_type'] : NULL;
    $receiver_email = (isset($response['receiver_email'])) ? $response['receiver_email'] : NULL;
    $receiver_id = (isset($response['receiver_id'])) ? $response['receiver_id'] : NULL;
    $test_ipn = (isset($response['test_ipn'])) ? $response['test_ipn'] : NULL;
    $txn_id = (isset($response['txn_id'])) ? $response['txn_id'] : NULL;
    $txn_type = (isset($response['txn_type'])) ? $response['txn_type'] : NULL;
    $verify_sign = (isset($response['verify_sign'])) ? $response['verify_sign'] : NULL;

    // Connect to Database
    $pdo = new PDO('mysql:host=' . DB_HOST . ';dbname='.DB_NAME, DB_USER, DB_PASS);

    // Check if we already have this IPN transaction, and exit if we do
    $verify_stmt = $pdo->query("SELECT COUNT(`id`) as total FROM `ipn_log` WHERE `verify_sign` = '{$verify_sign}'");
    $verify_result = $verify_stmt->fetch(PDO::FETCH_ASSOC);
    $verify_total = intval($verify_result['total']);

    // Only move forward if unique transaction
    if ($verify_total === 0) {
      // Log IPN
      try {
        $pdo->query("INSERT INTO `ipn_log` VALUES (NULL, '{$address_city}', '{$address_country_code}', '{$address_country}', '{$address_name}', '{$address_state}', '{$address_status}', '{$address_street}', '{$address_zip}', '{$custom}', '{$first_name}', '{$invoice}', '{$item_name}', '{$item_number}', '{$last_name}', '{$mc_currency}', '{$mc_fee}', '{$mc_gross}', '{$mc_handling}', '{$mc_shipping}', '{$notify_version}', '{$payer_email}', '{$payer_status}', '{$payment_date}', '{$payment_status}', '{$payment_type}', '{$receiver_email}', '{$receiver_id}', '{$test_ipn}', '{$txn_id}', '{$txn_type}', '{$verify_sign}')");
      } catch (Exception $e) {}


      // Calculate Number of Mailers
      $cost_per_mailer = floatval(COST_PER_MAILER);
      $total = floatval($mc_gross);

      // "Flip a Coin" to see if we should round up or down
      if (rand(0, 1) == 1) {
        $petitions_to_mail = ceil($total / $cost_per_mailer);
      } else {
        $petitions_to_mail = floor($total / $cost_per_mailer);
      }

      // Stop if we can't mail anything
      if ($total <= 0 || $petitions_to_mail <= 0) {
        exit;
      }

      if (LOB_ENABLED === TRUE) {
        // Fire off letters
        $api_key = (TEST_MODE) ? LOB_TEST_API_KEY : LOB_LIVE_API_KEY;
        $lob = new \Lob\Lob($api_key);

        $from_address = $lob->addresses()->create(array(
          'name'          => 'StayWoke',
          'address_line1' => 'PO Box 540717',
          'address_city'  => 'Orlando',
          'address_state' => 'FL',
          'address_zip'   => '32854-0717'
        ));
      }

      $stmt = $pdo->query("SELECT * FROM address_list WHERE `mailed` = 0 AND `processed` = 0 ORDER BY RAND() LIMIT {$petitions_to_mail}");

      while ($row = $stmt->fetch(PDO::FETCH_ASSOC))
      {
        // Check if we should fire off Lob ABI Calls
        if (LOB_ENABLED === TRUE) {
          try {
            $to_address = $lob->addresses()->create(array(
              'name'          => $row['name'],
              'address_line1' => $row['address'],
              'address_city'  => $row['city'],
              'address_state' => $row['state'],
              'address_zip'   => $row['zipcode']
            ));

            $letter = $lob->letters()->create(array(
              'to'    => $to_address['id'],
              'from'  => $from_address['id'],
              'file'  => LOB_TEMPLATE_ID,
              'color' => true
            ));

            $pdo->query('UPDATE `address_list` SET `mailed` = 1, `processed` = 1, `status` = "Letter Sent", `process_date` = NOW() WHERE `id` = ' . $row['id']);
          } catch (Exception $e) {
            $pdo->query('UPDATE `address_list` SET `processed` = 1, `status` = "' . $e->getMessage() . '", `process_date` = NOW() WHERE `id` = ' . $row['id']);
          }
        } else {
          $pdo->query('UPDATE address_list SET `mailed` = 1, `processed` = 1, `status` = "Donation Collected", `process_date` = NOW() WHERE `id` = ' . $row['id']);
        }
      }

      // Update Mailings File now that Database is Updated
      $mailings = $pdo->query("SELECT `a`.`zipcode`, COUNT(`a`.`id`) as 'count', `z`.`latitude` AS latitude, `z`.`longitude` AS longitude FROM `address_list` a INNER JOIN `zipcode` z ON `a`.`zipcode` = `z`.`zipcode` WHERE `a`.`mailed` = 1 GROUP BY `a`.`zipcode`, `z`.`latitude`, `z`.`longitude`")->fetchAll(PDO::FETCH_ASSOC);
      $total = 0;
      $data = array();
      foreach ($mailings as $row) {
        $total += intval($row['count'], 10);
        if ($row['latitude'] && $row['longitude']) {
          $data[] = array(
            'zipcode' => $row['zipcode'],
            'count' => intval($row['count'], 10),
            'z' => intval($row['count'], 10),
            'lat' => $row['latitude'],
            'lon' => $row['longitude']
          );
        }
      }

      $json = json_encode(array('total' => $total, 'zipcodes' => $data), JSON_PRETTY_PRINT);
      file_put_contents(dirname(__FILE__) . '/cache/mailings.json', $json, LOCK_EX);
    }
  }
}
